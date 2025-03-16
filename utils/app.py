from flask import Flask, request, jsonify, render_template
import nltk
import numpy as np
import json
import random
from sklearn.neural_network import MLPClassifier
from sklearn.feature_extraction.text import TfidfVectorizer
import logging
from flask_cors import CORS
import mysql.connector
from datetime import datetime
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer

# Download required NLTK data
nltk.download('punkt')
nltk.download('stopwords')
nltk.download('wordnet')

# Initialize Flask app
app = Flask(__name__)
CORS(app)  # Enable CORS for API access

# Setup logging
logging.basicConfig(level=logging.INFO)

# Initialize NLTK tools
lemmatizer = WordNetLemmatizer()
stop_words = set(stopwords.words('english'))

def preprocess(text):
    """Preprocesses input text using NLTK."""
    tokens = word_tokenize(text.lower())
    lemmatized = [lemmatizer.lemmatize(token) for token in tokens if token.isalnum() and token not in stop_words]
    return ' '.join(lemmatized)

# Load intents
try:
    with open('intents.json', 'r') as file:
        data = json.load(file)
except FileNotFoundError:
    logging.error("Intents file not found.")
    data = {'intents': []}

patterns = []
tags = []
responses = {}
for intent in data['intents']:
    for pattern in intent['patterns']:
        pattern = preprocess(pattern)
        patterns.append(pattern)
        tags.append(intent['tag'])
    responses[intent['tag']] = intent['responses']

# Train the model
vectorizer = TfidfVectorizer()
X = vectorizer.fit_transform(patterns)
tag_to_code = {tag: i for i, tag in enumerate(set(tags))}
code_to_tag = {i: tag for tag, i in tag_to_code.items()}
y = np.array([tag_to_code[tag] for tag in tags])
model = MLPClassifier(hidden_layer_sizes=(50, 50), max_iter=1000, random_state=42, alpha=0.01)
model.fit(X, y)

# Database connection
def get_db_connection():
    return mysql.connector.connect(
        host="localhost",
        user="root",
        password="",  # Replace with your MySQL password
        database="tms"
    )

# Database functions
def list_tour_packages():
    conn = get_db_connection()
    cursor = conn.cursor(buffered=True)
    try:
        cursor.execute("SELECT PackageId, PackageName, PackagePrice, PackageLocation FROM tbltourpackages")
        packages = cursor.fetchall()
        package_list = [f"ID: {pkg_id} - {pkg_name}, Location: {pkg_loc}, Price: {price}" for pkg_id, pkg_name, price, pkg_loc in packages]
        return "\n".join(package_list) if package_list else "No packages available."
    finally:
        cursor.close()
        conn.close()

def get_package_details(package_id):
    conn = get_db_connection()
    cursor = conn.cursor(buffered=True)
    try:
        query = "SELECT PackageName, PackageType, PackageLocation, PackagePrice, PackageDetails FROM tbltourpackages WHERE PackageId = %s"
        cursor.execute(query, (package_id,))
        result = cursor.fetchone()
        if result:
            name, pkg_type, location, price, details = result
            return f"Package: {name}\nType: {pkg_type}\nLocation: {location}\nPrice: {price}\nDetails: {details}"
        return "Package not found."
    finally:
        cursor.close()
        conn.close()

def book_tour_package(package_id, first_name, email, phone, name_on_card, card_number, exp_month, exp_year, country, street1, street2, city, state, pincode, additional_info):
    conn = get_db_connection()
    cursor = conn.cursor(buffered=True)
    try:
        query = """
        INSERT INTO booking (PackageId, FirstName, Email, Phone, NameOnCard, CardNumber, ExpMonth, ExpYear, Country, StreetLine1, StreetLine2, City, State1, Pincode, Additional_Information, status, BookingTime)
        VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, 0, NOW())
        """
        cursor.execute(query, (package_id, first_name, email, phone, name_on_card, card_number, exp_month, exp_year, country, street1, street2, city, state, pincode, additional_info))
        conn.commit()
        booking_id = cursor.lastrowid
        return f"Your booking has been confirmed! Booking ID: {booking_id}"
    except Exception as e:
        logging.error(f"Booking error: {e}")
        return "An error occurred while booking your tour."
    finally:
        cursor.close()
        conn.close()

def cancel_booking(booking_id):
    conn = get_db_connection()
    cursor = conn.cursor(buffered=True)
    try:
        cursor.execute("UPDATE booking SET status = 2, CancelledBy = 'U' WHERE BookingId = %s", (booking_id,))
        if cursor.rowcount > 0:
            conn.commit()
            return "Your booking has been successfully cancelled."
        return "Booking ID not found."
    finally:
        cursor.close()
        conn.close()

# Chatbot response logic
def get_response(user_input, context):
    try:
        if context.get("state") == "book_tour":
            step = context.get("step", "waiting_for_name")
            if step == "waiting_for_name":
                context["first_name"] = user_input
                context["step"] = "waiting_for_email"
                return "Please provide your email address.", context
            elif step == "waiting_for_email":
                context["email"] = user_input
                context["step"] = "waiting_for_phone"
                return "Please provide your phone number.", context
            elif step == "waiting_for_phone":
                context["phone"] = user_input
                context["step"] = "waiting_for_package_id"
                return "Please provide the Package ID you want to book.", context
            elif step == "waiting_for_package_id":
                context["package_id"] = user_input
                context["step"] = "waiting_for_card_name"
                return "Please provide the name on your card.", context
            elif step == "waiting_for_card_name":
                context["name_on_card"] = user_input
                context["step"] = "waiting_for_card_number"
                return "Please provide your card number.", context
            elif step == "waiting_for_card_number":
                context["card_number"] = user_input
                context["step"] = "waiting_for_exp_month"
                return "Please provide the expiration month (e.g., 12).", context
            elif step == "waiting_for_exp_month":
                context["exp_month"] = user_input
                context["step"] = "waiting_for_exp_year"
                return "Please provide the expiration year (e.g., 2026).", context
            elif step == "waiting_for_exp_year":
                context["exp_year"] = user_input
                context["step"] = "waiting_for_country"
                return "Please provide your country.", context
            elif step == "waiting_for_country":
                context["country"] = user_input
                context["step"] = "waiting_for_street1"
                return "Please provide your street address (Line 1).", context
            elif step == "waiting_for_street1":
                context["street1"] = user_input
                context["step"] = "waiting_for_street2"
                return "Please provide your street address (Line 2, optional).", context
            elif step == "waiting_for_street2":
                context["street2"] = user_input
                context["step"] = "waiting_for_city"
                return "Please provide your city.", context
            elif step == "waiting_for_city":
                context["city"] = user_input
                context["step"] = "waiting_for_state"
                return "Please provide your state.", context
            elif step == "waiting_for_state":
                context["state"] = user_input
                context["step"] = "waiting_for_pincode"
                return "Please provide your pincode.", context
            elif step == "waiting_for_pincode":
                context["pincode"] = user_input
                context["step"] = "waiting_for_additional_info"
                return "Any additional information you'd like to provide?", context
            elif step == "waiting_for_additional_info":
                context["additional_info"] = user_input
                response = book_tour_package(
                    context["package_id"], context["first_name"], context["email"], context["phone"],
                    context["name_on_card"], context["card_number"], context["exp_month"], context["exp_year"],
                    context["country"], context["street1"], context["street2"], context["city"],
                    context["state"], context["pincode"], context["additional_info"]
                )
                context["state"] = None
                return response, context

        if context.get("state") == "cancel_booking":
            response = cancel_booking(user_input)
            context["state"] = None
            return response, context

        if context.get("state") == "package_details":
            response = get_package_details(user_input)
            context["state"] = None
            return response, context

        preprocessed_input = preprocess(user_input)
        input_vector = vectorizer.transform([preprocessed_input])
        predicted_code = model.predict(input_vector)[0]
        predicted_tag = code_to_tag.get(predicted_code, None)

        if predicted_tag:
            response = random.choice(responses[predicted_tag])
            if predicted_tag == "list_packages":
                response += "\n" + list_tour_packages()
            elif predicted_tag in ["book_tour", "cancel_booking", "package_details"]:
                context["state"] = predicted_tag
                if predicted_tag == "book_tour":
                    context["step"] = "waiting_for_name"
        else:
            response = "I’m not sure I understand. Could you please rephrase?"

        return response, context

    except Exception as e:
        logging.error(f"Error in get_response: {e}")
        return "An error occurred while processing your request.", context

# Routes
@app.route('/')
def index():
    return render_template('index.html')

@app.route('/chat', methods=['POST'])
def chat():
    try:
        data = request.json
        user_input = data.get('message')
        context = data.get('context', {})
        if not user_input:
            return jsonify({'response': 'No message provided.'}), 400
        response, updated_context = get_response(user_input, context)
        return jsonify({'response': response, 'context': updated_context})
    except Exception as e:
        logging.error(f"Error in /chat endpoint: {e}")
        return jsonify({'response': "An error occurred."}), 500

# Example TMS route
@app.route('/packages')
def packages():
    conn = get_db_connection()
    cursor = conn.cursor()
    cursor.execute("SELECT PackageId, PackageName, PackagePrice FROM tbltourpackages")
    packages = cursor.fetchall()
    cursor.close()
    conn.close()
    return render_template('packages.html', packages=packages)

if __name__ == '__main__':
    app.run(debug=True)