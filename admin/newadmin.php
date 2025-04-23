<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Upload Place Data</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        body {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
        }
        .form-container {
            background: rgba(30, 41, 59, 0.85);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.5rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            max-width: 800px;
            width: 100%;
            padding: 2.5rem;
            animation: slideIn 0.6s ease-out;
        }
        #map {
            height: 450px;
            border-radius: 1rem;
            border: 2px solid rgba(255, 255, 255, 0.2);
            transition: border-color 0.3s ease;
        }
        #map:hover {
            border-color: #60a5fa;
        }
        .custom-file-input {
            position: relative;
            display: inline-block;
            width: 100%;
        }
        .custom-file-input input[type="file"] {
            opacity: 0;
            width: 100%;
            height: 100%;
            position: absolute;
            cursor: pointer;
        }
        .custom-file-input-label {
            background: linear-gradient(to right, #3b82f6, #60a5fa);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            display: inline-block;
            cursor: pointer;
            transition: transform 0.3s ease, background 0.3s ease;
        }
        .custom-file-input-label:hover {
            transform: translateY(-2px);
            background: linear-gradient(to right, #2563eb, #3b82f6);
        }
        .image-preview {
            max-width: 100%;
            max-height: 150px;
            border-radius: 0.5rem;
            margin-top: 1rem;
            display: none;
        }
        .required::after {
            content: '*';
            color: #f87171;
            margin-left: 0.25rem;
        }
        .error-message {
            color: #f87171;
            font-size: 0.875rem;
            margin-top: 0.25rem;
            display: none;
        }
        .loading .spinner {
            display: inline-block;
            border: 3px solid #ffffff;
            border-top: 3px solid transparent;
            border-radius: 50%;
            width: 1.5rem;
            height: 1.5rem;
            animation: spin 1s linear infinite;
            margin-right: 0.5rem;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        @media (max-width: 768px) {
            #map {
                height: 350px;
            }
            .form-container {
                padding: 1.5rem;
            }
        }
        @media (max-width: 640px) {
            #map {
                height: 300px;
            }
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2 class="text-4xl font-extrabold text-center text-white mb-8">Upload New Place</h2>
        <form id="placeForm" action="upload_handler.php" method="post" enctype="multipart/form-data" class="space-y-8" novalidate>
            <!-- Place Name -->
            <div>
                <label for="placename" class="block text-sm font-medium text-gray-200 required">Place Name</label>
                <input type="text" id="placename" name="placename" required
                       class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                       placeholder="Enter place name" aria-required="true">
                <p class="error-message" id="placename-error">Place name is required</p>
            </div>

            <!-- Activities -->
            <div>
                <label for="activities" class="block text-sm font-medium text-gray-200">Activities (comma separated)</label>
                <textarea id="activities" name="activities" rows="3"
                          class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                          placeholder="e.g., hiking, sightseeing, rafting"></textarea>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-200">Description</label>
                <textarea id="description" name="description" rows="5"
                          class="mt-1 block w-full px-4 py-3 bg-gray-800 border border-gray-600 rounded-lg text-white placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 transition duration-300"
                          placeholder="Describe the place in detail"></textarea>
            </div>

            <!-- Map -->
            <div>
                <label for="map" class="block text-sm font-medium text-gray-200 required">Select Location on Map</label>
                <div id="map" class="mt-1 relative">
                    <div class="absolute top-2 right-2 z-[1000]">
                        <select id="tileLayer" class="px-2 py-1 bg-gray-800 text-white rounded-md border border-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="street">Street Map</option>
                            <option value="satellite">Satellite</option>
                        </select>
                    </div>
                </div>
                <input type="hidden" id="placelatlong" name="placelatlong" aria-required="true">
                <p class="error-message" id="placelatlong-error">Please select a location on the map</p>
            </div>

            <!-- Image Upload -->
            <div>
                <label for="imagesrc" class="block text-sm font-medium text-gray-200 required">Upload Image</label>
                <div class="custom-file-input">
                    <input type="file" id="imagesrc" name="imagesrc" accept="image/jpeg,image/png" required aria-required="true">
                    <span class="custom-file-input-label">Choose Image</span>
                </div>
                <p class="mt-1 text-sm text-gray-400">Supported formats: JPG, PNG (max 5MB)</p>
                <img id="imagePreview" class="image-preview" alt="Image preview">
                <p class="error-message" id="imagesrc-error">Please upload an image</p>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" id="submitBtn"
                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg shadow-lg hover:from-blue-700 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 focus:ring-offset-gray-900 transition duration-300 flex items-center justify-center">
                    <span class="spinner hidden"></span>
                    <span>Upload Place</span>
                </button>
            </div>
        </form>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script>
        // Initialize Leaflet map
        const map = L.map('map').setView([27.7172, 85.3240], 13);

        // Tile layers
        const streetLayer = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        });
        const satelliteLayer = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}', {
            maxZoom: 19,
            attribution: '© <a href="https://www.esri.com/">Esri</a>'
        });

        // Default layer
        streetLayer.addTo(map);

        // Tile layer switcher
        document.getElementById('tileLayer').addEventListener('change', (e) => {
            map.eachLayer(layer => {
                if (layer instanceof L.TileLayer) map.removeLayer(layer);
            });
            if (e.target.value === 'street') {
                streetLayer.addTo(map);
            } else {
                satelliteLayer.addTo(map);
            }
        });

        // Custom marker icon
        const customIcon = L.icon({
            iconUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-icon.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
            shadowUrl: 'https://unpkg.com/leaflet@1.9.3/dist/images/marker-shadow.png',
            shadowSize: [41, 41]
        });

        let marker;
        function onMapClick(e) {
            const latlng = e.latlng;
            if (marker) {
                marker.setLatLng(latlng);
                marker.bindPopup(`Location: ${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)}`).openPopup();
            } else {
                marker = L.marker(latlng, { icon: customIcon, draggable: true }).addTo(map)
                    .bindPopup(`Location: ${latlng.lat.toFixed(5)}, ${latlng.lng.toFixed(5)}`).openPopup();
                marker.on('dragend', () => {
                    const pos = marker.getLatLng();
                    document.getElementById('placelatlong').value = `${pos.lat},${pos.lng}`;
                    marker.bindPopup(`Location: ${pos.lat.toFixed(5)}, ${pos.lng.toFixed(5)}`).openPopup();
                });
            }
            document.getElementById('placelatlong').value = `${latlng.lat},${latlng.lng}`;
            document.getElementById('placelatlong-error').style.display = 'none';
        }

        map.on('click', onMapClick);

        // Image preview
        const imageInput = document.getElementById('imagesrc');
        const imagePreview = document.getElementById('imagePreview');
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (file && file.size <= 5 * 1024 * 1024 && ['image/jpeg', 'image/png'].includes(file.type)) {
                const reader = new FileReader();
                reader.onload = () => {
                    imagePreview.src = reader.result;
                    imagePreview.style.display = 'block';
                    gsap.fromTo(imagePreview, { opacity: 0, scale: 0.8 }, { opacity: 1, scale: 1, duration: 0.5 });
                    document.getElementById('imagesrc-error').style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
                document.getElementById('imagesrc-error').textContent = 'Please upload a valid JPG/PNG image (max 5MB)';
                document.getElementById('imagesrc-error').style.display = 'block';
            }
        });

        // Form validation and loading state
        const form = document.getElementById('placeForm');
        const submitBtn = document.getElementById('submitBtn');
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Validate place name
            const placename = document.getElementById('placename').value.trim();
            if (!placename) {
                document.getElementById('placename-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('placename-error').style.display = 'none';
            }

            // Validate map location
            const placelatlong = document.getElementById('placelatlong').value;
            if (!placelatlong) {
                document.getElementById('placelatlong-error').style.display = 'block';
                isValid = false;
            } else {
                document.getElementById('placelatlong-error').style.display = 'none';
            }

            // Validate image
            const imagesrc = document.getElementById('imagesrc').files[0];
            if (!imagesrc) {
                document.getElementById('imagesrc-error').textContent = 'Please upload an image';
                document.getElementById('imagesrc-error').style.display = 'block';
                isValid = false;
            }

            if (isValid) {
                submitBtn.disabled = true;
                submitBtn.classList.add('loading');
                submitBtn.querySelector('span:not(.spinner)').textContent = 'Uploading...';
                gsap.to(submitBtn, { scale: 0.95, duration: 0.2 });

                // Simulate form submission (replace with actual submission)
                setTimeout(() => {
                    form.submit();
                }, 1000);
            }
        });

        // GSAP animations for form fields
        gsap.from('.form-container > form > div', {
            opacity: 0,
            y: 20,
            stagger: 0.1,
            duration: 0.5,
            ease: 'power2.out',
            delay: 0.3
        });
    </script>
</body>
</html>