import numpy as np
from PIL import Image
from keras.models import load_model
from flask import Flask, request, jsonify, render_template

# Initialize Flask application
app = Flask(__name__)

# Load the pretrained model
model = load_model('model/first_Mod.keras')

# Define classes
classes = {
    0: "Bulging Eyes",
    1: "Cataracts",
    2: "Crossed Eyes",
    3: "Glaucoma",
    4: "Uveitis"
}

# Function to preprocess the input image
def preprocess_image(image):
    img = Image.open(image)
    img = img.resize((224, 224))
    img = np.array(img)
    img = img.astype('float32') / 255
    return img

# Function to make predictions
def predict(image):
    img = preprocess_image(image)
    img = np.expand_dims(img, axis=0)
    prediction = model.predict(img)
    predicted_class = np.argmax(prediction)
    confidence = prediction[0][predicted_class]
    return classes[predicted_class], confidence

# Route for the root URL
@app.route('/')
def index():
    return render_template('dashboard.php')

# Route for prediction
@app.route('/predict', methods=['POST'])
def make_prediction():
    if 'image' not in request.files:
        return jsonify({'error': 'No file part'})

    image = request.files['image']
    if image.filename == '':
        return jsonify({'error': 'No selected file'})

    try:
        class_name, confidence = predict(image)
        return jsonify({'class': class_name, 'confidence': float(confidence)})
    except Exception as e:
        return jsonify({'error': str(e)})

# Main
if __name__ == '__main__':
    app.run(debug=True)
