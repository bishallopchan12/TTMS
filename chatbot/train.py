import nltk
import json
import numpy as np
from tensorflow.keras.models import Sequential
from tensorflow.keras.layers import Dense, Dropout
from sklearn.feature_extraction.text import TfidfVectorizer
from nltk.corpus import stopwords
from nltk.tokenize import word_tokenize
from nltk.stem import WordNetLemmatizer
import pickle
import logging

nltk.download('punkt', quiet=True)
nltk.download('stopwords', quiet=True)
nltk.download('wordnet', quiet=True)

logging.basicConfig(level=logging.INFO)
logger = logging.getLogger(__name__)

lemmatizer = WordNetLemmatizer()
stop_words = set(stopwords.words('english'))

def preprocess(text):
    tokens = word_tokenize(text.lower())
    return ' '.join([lemmatizer.lemmatize(token) for token in tokens if token.isalnum() and token not in stop_words])

# Load intents
try:
    with open('C:/xampp/htdocs/B&BTravel/chatbot/intents.json', 'r', encoding='utf-8') as f:
        intents = json.load(f)
    logger.info("Intents loaded successfully")
except Exception as e:
    logger.error(f"Failed to load intents.json: {e}")
    raise

# Prepare training data
patterns = []
tags = []
for intent in intents['intents']:
    for pattern in intent['patterns']:
        processed_pattern = preprocess(pattern)
        if processed_pattern:  # Ensure no empty strings
            patterns.append(processed_pattern)
            tags.append(intent['tag'])

logger.info(f"Loaded {len(patterns)} patterns across {len(set(tags))} intents")

# Vectorize patterns
vectorizer = TfidfVectorizer(max_features=1000)  # Kept at 1000 for broader vocabulary
X = vectorizer.fit_transform(patterns).toarray()
y = np.zeros((len(tags), len(set(tags))))
tag_to_index = {tag: i for i, tag in enumerate(set(tags))}
for i, tag in enumerate(tags):
    y[i, tag_to_index[tag]] = 1

logger.info(f"Feature matrix shape: {X.shape}, Output shape: {y.shape}")

# Build and train model
model = Sequential([
    Dense(128, input_shape=(X.shape[1],), activation='relu'),
    Dropout(0.5),
    Dense(64, activation='relu'),
    Dropout(0.5),
    Dense(len(set(tags)), activation='softmax')
])

model.compile(loss='categorical_crossentropy', optimizer='adam', metrics=['accuracy'])
history = model.fit(X, y, epochs=200, batch_size=5, validation_split=0.2, verbose=1)

# Log final accuracy
logger.info(f"Training completed. Final accuracy: {history.history['accuracy'][-1]:.4f}, Validation accuracy: {history.history['val_accuracy'][-1]:.4f}")

# Save model and artifacts
try:
    model.save('C:/xampp/htdocs/B&BTravel/chatbot/chatbot_model.h5')
    with open('C:/xampp/htdocs/B&BTravel/chatbot/vectorizer.pkl', 'wb') as f:
        pickle.dump(vectorizer, f)
    with open('C:/xampp/htdocs/B&BTravel/chatbot/tag_to_index.pkl', 'wb') as f:
        pickle.dump(tag_to_index, f)
    logger.info("Model and artifacts saved successfully")
except Exception as e:
    logger.error(f"Failed to save model/artifacts: {e}")
    raise