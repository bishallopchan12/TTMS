import nltk
import json
import numpy as np
import tensorflow as tf
from tensorflow.keras.models import load_model
from sklearn.feature_extraction.text import TfidfVectorizer
from nltk.tokenize import word_tokenize
from nltk.corpus import stopwords
from nltk.stem import WordNetLemmatizer
import pickle
import mysql.connector
from flask import Flask, request, jsonify, session
from flask_cors import CORS
from flask_session import Session
import random
import uuid
import logging
import os
from difflib import get_close_matches

nltk.download('punkt', quiet=True)
nltk.download('stopwords', quiet=True)
nltk.download('wordnet', quiet=True)

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

app = Flask(__name__)
CORS(app, supports_credentials=True, origins=["http://localhost"])
app.config['SESSION_TYPE'] = 'filesystem'
app.config['SESSION_FILE_DIR'] = os.path.join(os.path.dirname(__file__), 'flask_session')
app.config['SESSION_PERMANENT'] = False
Session(app)

def get_db_connection():
    try:
        conn = mysql.connector.connect(host="127.0.0.1", user="root", password="", database="tms")
        logger.info("Database connection established")
        return conn
    except mysql.connector.Error as e:
        logger.error(f"Database connection failed: {e}")
        return None

lemmatizer = WordNetLemmatizer()
stop_words = set(stopwords.words('english'))

def preprocess(text):
    tokens = word_tokenize(text.lower())
    return ' '.join([lemmatizer.lemmatize(token) for token in tokens if token.isalnum() and token not in stop_words])

try:
    model = load_model('C:/xampp/htdocs/B&BTravel/chatbot/chatbot_model.h5')
    with open('C:/xampp/htdocs/B&BTravel/chatbot/vectorizer.pkl', 'rb') as f:
        vectorizer = pickle.load(f)
    with open('C:/xampp/htdocs/B&BTravel/chatbot/tag_to_index.pkl', 'rb') as f:
        tag_to_index = pickle.load(f)
    with open('C:/xampp/htdocs/B&BTravel/chatbot/intents.json', 'r', encoding='utf-8') as f:
        intents = json.load(f)
    responses = {intent['tag']: intent['responses'] for intent in intents['intents']}
    index_to_tag = {v: k for k, v in tag_to_index.items()}
except Exception as e:
    logger.error(f"Failed to load model/artifacts: {e}")
    raise

def predict_intent(user_input):
    processed_input = preprocess(user_input)
    input_vector = vectorizer.transform([processed_input]).toarray()
    prediction = model.predict(input_vector, verbose=0)[0]
    predicted_index = np.argmax(prediction)
    confidence = float(prediction[predicted_index])
    intent = index_to_tag[predicted_index]
    top_indices = np.argsort(prediction)[-3:][::-1]
    top_predictions = [(index_to_tag[i], float(prediction[i])) for i in top_indices]
    logger.info(f"User Input: '{user_input}', Processed: '{processed_input}', Intent: {intent}, Confidence: {confidence}, Top Predictions: {top_predictions}")
    return intent, confidence

# Updated Database Query Functions
def get_tour_package_info(package_name):
    conn = get_db_connection()
    if not conn:
        return None
    try:
        package_name = package_name.split('-')[0].strip()
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageDetails, PackageImage FROM tbltourpackages WHERE LOWER(PackageName) = %s", (package_name.lower(),))
        result = cursor.fetchone()
        logger.info(f"Package Query: PackageName='{package_name.lower()}', Result: {result}")
        cursor.close()
        conn.close()
        image = result[3] if result and result[3] else 'default.jpg'
        return {'name': result[0], 'price': result[1], 'details': result[2], 'image': image} if result else None
    except Exception as e:
        logger.error(f"Error fetching package: {e}")
        return None

def get_tour_package_info_list():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching package list: {e}")
        return []

def get_all_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName FROM tbltourpackages")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [p[0] for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching all packages: {e}")
        return []

def get_destination_info(destination_name):
    conn = get_db_connection()
    if not conn:
        return None
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT DestinationName, DestinationDetails, DestinationImage FROM tbldestination WHERE LOWER(DestinationName) LIKE %s", (f"%{destination_name.lower()}%",))
        result = cursor.fetchone()
        logger.info(f"Destination Query: DestinationName LIKE '%{destination_name.lower()}%', Result: {result}")
        cursor.close()
        conn.close()
        image = result[2] if result and result[2] else 'default.jpg'
        return {'name': result[0], 'details': result[1], 'image': image} if result else None
    except Exception as e:
        logger.error(f"Error fetching destination: {e}")
        return None

def get_destination_list():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT DestinationName, DestinationImage FROM tbldestination")
        destinations = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': d[0], 'image': d[1] or 'default.jpg'} for d in destinations] if destinations else []
    except Exception as e:
        logger.error(f"Error fetching destination list: {e}")
        return []

def get_all_destinations():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT DestinationName FROM tbldestination")
        destinations = cursor.fetchall()
        cursor.close()
        conn.close()
        return [d[0] for d in destinations] if destinations else []
    except Exception as e:
        logger.error(f"Error fetching all destinations: {e}")
        return []

def get_budget_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages WHERE PackagePrice < 15000 LIMIT 3")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching budget packages: {e}")
        return []

def get_group_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages WHERE PackageName LIKE '%Group%' OR PackagePrice BETWEEN 10000 AND 20000 LIMIT 3")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching group packages: {e}")
        return []

def get_solo_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages WHERE PackagePrice < 20000 LIMIT 3")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching solo packages: {e}")
        return []

def get_adventure_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages WHERE PackageName LIKE '%Adventure%' OR PackageName LIKE '%Trek%' LIMIT 3")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching adventure packages: {e}")
        return []

def get_relaxation_packages():
    conn = get_db_connection()
    if not conn:
        return []
    try:
        cursor = conn.cursor()
        cursor.execute("SELECT PackageName, PackagePrice, PackageImage FROM tbltourpackages WHERE PackageName LIKE '%Relax%' OR PackageName LIKE '%Safari%' LIMIT 3")
        packages = cursor.fetchall()
        cursor.close()
        conn.close()
        return [{'name': p[0], 'price': p[1], 'image': p[2] or 'default.jpg'} for p in packages] if packages else []
    except Exception as e:
        logger.error(f"Error fetching relaxation packages: {e}")
        return []

def get_response(user_input, context, confidence_threshold=0.45):
    try:
        intent, confidence = predict_intent(user_input)
        logger.info(f"Processing input: '{user_input}', Intent: {intent}, Confidence: {confidence}, Context: {context}")

        all_destinations = get_all_destinations()
        all_packages = get_all_packages()

        if "state" in context:
            if context["state"] == "asking_destination":
                dest_info = get_destination_info(user_input)
                if not dest_info:
                    matches = get_close_matches(user_input.lower(), [d.lower() for d in context.get("destinations", [])] + all_destinations, n=1, cutoff=0.6)
                    dest_info = get_destination_info(matches[0]) if matches else None
                if dest_info:
                    context["destination"] = dest_info
                    context["state"] = "destination_details"
                    image_url = f"http://localhost/B&BTravel/admin/destinationimages/{dest_info['image']}"
                    base_response = random.choice(responses.get("destination_details", ["Let’s dive into this magical place!"]))
                    return (
                        f"{base_response}\n"
                        f"🏞️ {dest_info['name']}: {dest_info['details'][:200]}...\n"
                        f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{dest_info['name']}'>\n"
                        f"Intrigued? Say 'list packages' to explore trips there or 'tell me more' for extra details!", context
                    )
                if confidence > 0.7 and intent not in ["destination_info", "popular_destinations"]:
                    context.clear()
                else:
                    return "😕 Can’t pinpoint that spot! Try one from the list or say 'list destinations' again!", context

            elif context["state"] == "asking_package":
                package_info = get_tour_package_info(user_input)
                if not package_info:
                    matches = get_close_matches(user_input.lower(), [p.lower() for p in context.get("packages", [])] + all_packages, n=1, cutoff=0.6)
                    package_info = get_tour_package_info(matches[0]) if matches else None
                if package_info:
                    context["package"] = package_info
                    context["state"] = "package_details"
                    image_url = f"http://localhost/B&BTravel/admin/packageimages/{package_info['image']}"
                    base_response = random.choice(responses.get("package_details", ["Here’s your travel treasure!"]))
                    return (
                        f"{base_response}\n"
                        f"🎉 {package_info['name']} - Rs{package_info['price']}\n"
                        f"📜 {package_info['details'][:200]}...\n"
                        f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{package_info['name']}'>\n"
                        f"Thrilled? Say 'book now' or click <a href='http://localhost/B&BTravel/booking.php'>here</a> to book!", context
                    )
                return "😕 That package’s hiding! Try one from the list or say 'list packages' again!", context

            elif context["state"] == "confirm_booking" and "package" in context:
                if user_input.lower() in ["yes", "confirm", "sure", "yep", "book now"]:
                    package = context["package"]
                    context.clear()
                    return (
                        f"✅ Awesome! {package['name']} is yours for Rs{package['price']}! "
                        f"Lock it in <a href='http://localhost/B&BTravel/booking.php'>here</a>!", {}
                    )
                elif user_input.lower() in ["no", "cancel", "stop"]:
                    context.clear()
                    return "🛑 All good, booking cancelled! What’s your next adventure?", {}
                return "🤔 Quick call—say 'yes' to book or 'no' to pass!", context

        if confidence < confidence_threshold:
            base_response = random.choice(responses.get("no_answer", ["Hmm, I’m stumped! Could you rephrase that?"]))
            matches = get_close_matches(user_input.lower(), all_destinations + all_packages, n=2, cutoff=0.6)
            if matches:
                return f"{base_response}\n🌟 Did you mean: {', '.join(matches)}? Give one a try!", context
            return f"{base_response}\n🌍 How about 'list destinations' or 'list packages' to spark some ideas?", context

        if intent == "greeting":
            return f"{random.choice(responses['greeting'])}\n🌟 Where shall we journey today?", context

        elif intent == "goodbye" or user_input.lower() == "reset":
            context.clear()
            return f"{random.choice(responses['goodbye'])}\nSafe travels—see you soon!", {}

        elif intent == "thanks":
            return f"{random.choice(responses['thanks'])}\nWhat’s next on your travel list?", context

        elif intent == "list_packages":
            packages = get_tour_package_info_list()
            base_response = random.choice(responses["list_packages"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌍 Which one’s calling your name?", context
            return f"{base_response}\n🌧️ No packages yet—check back soon!", context

        elif intent == "tour_package_info":
            package_info = get_tour_package_info(user_input)
            base_response = random.choice(responses.get("package_details", ["Here’s a gem for you!"]))
            if package_info:
                context["package"] = package_info
                context["state"] = "package_details"
                image_url = f"http://localhost/B&BTravel/admin/packageimages/{package_info['image']}"
                return (
                    f"{base_response}\n"
                    f"🎉 {package_info['name']} - Rs{package_info['price']}\n"
                    f"📜 {package_info['details'][:200]}...\n"
                    f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{package_info['name']}'>\n"
                    f"Ready? Say 'book now' or click <a href='http://localhost/B&BTravel/booking.php'>here</a>!", context
                )
            return f"{base_response}\n🌟 Name a package or say 'list packages' to browse!", context

        elif intent == "book_tour" or user_input.lower() == "book now":
            base_response = random.choice(responses["book_tour"])
            if "package" in context and context.get("state") == "package_details":
                package = context["package"]
                context["state"] = "confirm_booking"
                image_url = f"http://localhost/B&BTravel/admin/packageimages/{package['image']}"
                return (
                    f"{base_response}\n"
                    f"🚗 Booking {package['name']} for Rs{package['price']}—exciting!\n"
                    f"Details: {package['details'][:100]}...\n"
                    f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{package['name']}'>\n"
                    f"Say 'yes' to confirm or 'no' to rethink!", context
                )
            return f"{base_response}\n🌍 Pick a package first—say 'list packages'!", context

        elif intent == "cancel_booking":
            return f"{random.choice(responses['cancel_booking'])}\nWhat’s your next travel vibe?", context

        elif intent == "popular_destinations":
            destinations = get_destination_list()
            base_response = random.choice(responses["popular_destinations"])
            if destinations:
                dest_list = "\n".join([f"🏞️ {d['name']}\n<img src='http://localhost/B&BTravel/admin/destinationimages/{d['image']}' style='max-width:100%;border-radius:10px;' alt='{d['name']}'>" for d in destinations])
                context["state"] = "asking_destination"
                context["destinations"] = [d['name'] for d in destinations]
                return f"{base_response}\n{dest_list}\n🌍 Where’s your next stop? Type a name!", context
            return f"{base_response}\n🌧️ No destinations yet—stay tuned!", context

        elif intent == "destination_info":
            dest_info = get_destination_info(user_input)
            base_response = random.choice(responses.get("destination_details", ["Let’s explore this spot!"]))
            if dest_info:
                context["destination"] = dest_info
                context["state"] = "destination_details"
                image_url = f"http://localhost/B&BTravel/admin/destinationimages/{dest_info['image']}"
                return (
                    f"{base_response}\n"
                    f"🏞️ {dest_info['name']}: {dest_info['details'][:200]}...\n"
                    f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{dest_info['name']}'>\n"
                    f"Love it? Say 'list packages' for trips or 'tell me more' for details!", context
                )
            return f"{base_response}\n🌟 Name a destination or say 'list destinations'!", context

        elif intent == "special_offers":
            packages = get_budget_packages()
            base_response = random.choice(responses["special_offers"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌟 Grab a deal—pick one!", context
            return f"{base_response}\n🌧️ No special offers right now—try 'list packages'!", context

        elif intent == "weather":
            return f"{random.choice(responses['weather'])}\nWhat’s next on your mind?", context

        elif intent == "travel_tips":
            return f"{random.choice(responses['travel_tips'])}\nGot more travel curiosities?", context

        elif intent == "culture":
            context.clear()
            return f"{random.choice(responses['culture'])}\nCurious about more? Ask away!", context

        elif intent == "food":
            return f"{random.choice(responses['food'])}\nWhat else tickles your taste buds?", context

        elif intent == "emergency":
            return f"{random.choice(responses['emergency'])}\nNeed more help? I’m here!", context

        elif intent == "about_us":
            return f"{random.choice(responses['about_us'])}\nWhat’s your next question?", context

        elif intent == "contact_us":
            return f"{random.choice(responses['contact_us'])}\nAnything else I can do?", context

        elif intent == "fun":
            return f"{random.choice(responses['fun'])}\nWant more fun? Just say so!", context

        elif intent == "budget_travel":
            packages = get_budget_packages()
            base_response = random.choice(responses["budget_travel"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌟 Budget bliss—pick one!", context
            return f"{base_response}\n🌧️ No budget trips—try 'list packages'!", context

        elif intent == "group_travel":
            packages = get_group_packages()
            base_response = random.choice(responses["group_travel"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌍 Group fun awaits—choose one!", context
            return f"{base_response}\n🌧️ No group trips—check 'list packages'!", context

        elif intent == "solo_travel":
            packages = get_solo_packages()
            base_response = random.choice(responses["solo_travel"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌟 Solo vibes—pick your path!", context
            return f"{base_response}\n🌧️ No solo trips—explore 'list packages'!", context

        elif intent == "adventure":
            packages = get_adventure_packages()
            base_response = random.choice(responses["adventure"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🌄 Adventure calls—which one’s yours?", context
            return f"{base_response}\n🌧️ No adventures yet—try 'list packages'!", context

        elif intent == "relaxation":
            packages = get_relaxation_packages()
            base_response = random.choice(responses["relaxation"])
            if packages:
                package_list = "\n".join([f"✨ {p['name']} - Rs{p['price']}\n<img src='http://localhost/B&BTravel/admin/packageimages/{p['image']}' style='max-width:100%;border-radius:10px;' alt='{p['name']}'>" for p in packages])
                context["state"] = "asking_package"
                context["packages"] = [p['name'] for p in packages]
                return f"{base_response}\n{package_list}\n🧘‍♂️ Chill time—where to?", context
            return f"{base_response}\n🌧️ No relaxation trips—check 'list packages'!", context

        matches = get_close_matches(user_input.lower(), all_destinations + all_packages, n=1, cutoff=0.6)
        if matches:
            if matches[0] in all_destinations:
                dest_info = get_destination_info(matches[0])
                if dest_info:
                    context["destination"] = dest_info
                    context["state"] = "destination_details"
                    image_url = f"http://localhost/B&BTravel/admin/destinationimages/{dest_info['image']}"
                    base_response = random.choice(responses.get("destination_details", ["Here’s a peek at this spot!"]))
                    return (
                        f"{base_response}\n"
                        f"🏞️ {dest_info['name']}: {dest_info['details'][:200]}...\n"
                        f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{dest_info['name']}'>\n"
                        f"Love it? Say 'list packages' or 'tell me more'!", context
                    )
            elif matches[0] in all_packages:
                package_info = get_tour_package_info(matches[0])
                if package_info:
                    context["package"] = package_info
                    context["state"] = "package_details"
                    image_url = f"http://localhost/B&BTravel/admin/packageimages/{package_info['image']}"
                    base_response = random.choice(responses.get("package_details", ["Here’s your adventure!"]))
                    return (
                        f"{base_response}\n"
                        f"🎉 {package_info['name']} - Rs{package_info['price']}\n"
                        f"📜 {package_info['details'][:200]}...\n"
                        f"<img src='{image_url}' style='max-width:100%;border-radius:10px;' alt='{package_info['name']}'>\n"
                        f"Ready? Say 'book now' or click <a href='http://localhost/B&BTravel/booking.php'>here</a>!", context
                    )

        return f"{random.choice(responses['no_answer'])}\n🌟 Try 'list destinations' or 'list packages' for some travel inspo!", context
    except Exception as e:
        logger.error(f"Error in get_response: {e}")
        return "😓 Oops! Something went wrong—let’s try again!", context

@app.route('/chatbot', methods=['POST'])
def chatbot_endpoint():
    try:
        data = request.get_json()
        user_input = data.get('message', '').strip()
        received_context = data.get('context', {})
        received_session_id = data.get('session_id')

        if not user_input:
            return jsonify({"response": "🌟 Namaste! Type something to kick off your adventure!", "context": received_context})

        if 'session_id' not in session or session['session_id'] != received_session_id:
            session['session_id'] = received_session_id or str(uuid.uuid4())
            session['context'] = received_context
            logger.info(f"New or synced session: {session['session_id']}, Context: {session['context']}")
        else:
            session['context'].update(received_context)

        context = session.get('context', {})
        logger.info(f"Received request: Input: '{user_input}', Session ID: {session['session_id']}, Initial Context: {context}")

        response, updated_context = get_response(user_input, context)
        session['context'] = updated_context
        logger.info(f"Response: '{response}', Updated Context: {updated_context}")
        return jsonify({
            "response": response,
            "context": updated_context,
            "session_id": session['session_id']
        })
    except Exception as e:
        logger.error(f"Error in chatbot_endpoint: {e}")
        return jsonify({"response": "😓 Server hiccup! Try again soon.", "context": {}}), 500

if __name__ == "__main__":
    session_dir = app.config['SESSION_FILE_DIR']
    if not os.path.exists(session_dir):
        os.makedirs(session_dir)
        logger.info(f"Created session directory: {session_dir}")
    app.run(host='0.0.0.0', port=5000, debug=True)