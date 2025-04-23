<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content=" curioswidth=device-width, initial-scale=1.0">
    <title>Travel and Tour Management System</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;600;800&display=swap" rel="stylesheet">
    <style>
        /* General Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Montserrat', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #155799 0%, #159957 100%);
            color: #fff;
            min-height: 100vh;
            padding: 40px 20px;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('https://images.unsplash.com/photo-1507521628349-6e9b8a9a1a3b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1950&q=80') no-repeat center center/cover;
            opacity: 0.1;
            z-index: -1;
            transform: translateY(0);
            transition: transform 0.1s ease;
        }

        body.scrolled::before {
            transform: translateY(calc(var(--scroll) * -0.2px));
        }

        h1 {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            margin: 30px 0;
            background: linear-gradient(45deg, #ff6f61, #ffeb3b);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
            animation: gradientShift 5s infinite linear;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            100% { background-position: 200% 50%; }
        }

        p {
            text-align: center;
            font-size: 1.2rem;
            color: #d1d5db;
            margin-bottom: 40px;
            line-height: 1.6;
        }

        #map {
            height: 500px;
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            position: relative;
            z-index: 1;
            transition: transform 0.4s ease;
        }

        #map:hover {
            transform: translateY(-5px);
        }

        /* Package List Styles */
        .package-list {
            margin: 60px auto;
            max-width: 1200px;
        }

        .package-item {
            display: flex;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 25px;
            margin-bottom: 30px;
            transition: all 0.4s ease;
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .package-item:hover {
            transform: translateY(-8px) rotateX(5deg);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.3);
        }

        .package-item img {
            width: 400px;
            height: 250px;
            object-fit: cover;
            border-radius: 15px;
            margin-right: 25px;
            transition: transform 0.5s ease;
        }

        .package-item:hover img {
            transform: scale(1.05);
        }

        .package-item::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 10% 20%, rgba(255, 111, 97, 0.2), transparent 50%);
            z-index: -1;
        }

        .package-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .package-details h3 {
            font-size: 2rem;
            font-weight: 700;
            color: #1e3c72;
            margin-bottom: 15px;
            position: relative;
        }

        .package-details h3::after {
            content: "";
            display: block;
            width: 60px;
            height: 4px;
            background: linear-gradient(to right, #ff6f61, #ffeb3b);
            margin-top: 10px;
            border-radius: 2px;
        }

        .package-details p {
            font-size: 1.15rem;
            color: #2d3748;
            margin-bottom: 10px;
            text-align: left;
            line-height: 1.7;
        }

        .package-details p strong {
            color: #ff6f61;
            font-weight: 600;
        }

        button,
        a {
            display: inline-block;
            color: #fff;
            background: linear-gradient(90deg, #ff6f61, #ffeb3b);
            padding: 12px 25px;
            border-radius: 10px;
            text-decoration: none;
            border: none;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        button:hover,
        a:hover {
            background: linear-gradient(90deg, #ffeb3b, #ff6f61);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .package-item {
                flex-direction: column;
                align-items: center;
            }

            .package-item img {
                margin-bottom: 20px;
                width: 100%;
                height: 200px;
            }

            .package-details h3 {
                font-size: 1.75rem;
            }

            .package-details p {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            h1 {
                font-size: 2rem;
            }

            p {
                font-size: 1rem;
            }

            #map {
                height: 400px;
            }

            .package-item img {
                height: 180px;
            }
        }
    </style>
</head>
<body>

<h1>Travel and Tour Management System</h1>
<p>Click on the map to set your current location and view the nearest places to travel!</p>
<div id="map"></div>
<div class="package-list" id="packageList"></div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Initialize the map
    const map = L.map('map').setView([27.7, 85.3], 10);

    // Add OpenStreetMap tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Create a global variable to hold the marker
    let currentMarker = null;

    // Function to calculate distance using Haversine formula
    function haversineDistance(coords1, coords2) {
        const toRad = (value) => value * Math.PI / 180;
        const R = 6371; // Radius of the Earth in kilometers
        const dLat = toRad(coords2[0] - coords1[0]);
        const dLon = toRad(coords2[1] - coords1[1]);
        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(toRad(coords1[0])) * Math.cos(toRad(coords2[0])) *
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        return R * c; // Distance in kilometers
    }

    // Fetch data from the database (AJAX request)
    async function fetchPlaces(userCoords) {
        const response = await fetch(`nearestplaces.php?lat=${userCoords[0]}&lng=${userCoords[1]}`); // Pass user coordinates
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const places = await response.json();
        return places;
    }

    // Display nearest places based on user coordinates
    async function displayNearestPlaces(userCoords) {
        try {
            const places = await fetchPlaces(userCoords);
            const nearestPlaces = places
                .map((place) => ({
                    ...place,
                    distance: haversineDistance(userCoords, [parseFloat(place.placelatlong.split(',')[0]), parseFloat(place.placelatlong.split(',')[1])]),
                }))
                .sort((a, b) => a.distance - b.distance)
                .slice(0, 5); // Get top 5 nearest places

            const packageList = document.getElementById('packageList');
            packageList.innerHTML = ''; // Clear previous results

            nearestPlaces.forEach((place) => {
                const packageItem = document.createElement('div');
                packageItem.classList.add('package-item');

                const packageImage = document.createElement('img');
                packageImage.src = place.imagesrc;
                packageItem.appendChild(packageImage);

                const packageDetails = document.createElement('div');
                packageDetails.classList.add('package-details');

                const packageTitle = document.createElement('h3');
                packageTitle.innerText = place.placename;

                const packageDescription = document.createElement('p');
                packageDescription.innerText = place.description;

                const packageActivities = document.createElement('p');
                packageActivities.innerHTML = `<strong>Activities:</strong> ${place.activities}`;

                const packageDistance = document.createElement('p');
                packageDistance.innerHTML = `<strong>Distance:</strong> ${place.distance.toFixed(2)} km`;

                packageDetails.appendChild(packageTitle);
                packageDetails.appendChild(packageDescription);
                packageDetails.appendChild(packageActivities);
                packageDetails.appendChild(packageDistance);
                packageItem.appendChild(packageDetails);
                packageList.appendChild(packageItem);
            });
        } catch (error) {
            console.error('Error fetching places:', error);
        }
    }

    // Handle map click
    map.on('click', (e) => {
        const userCoords = [e.latlng.lat, e.latlng.lng];

        // Add or update marker on map
        if (currentMarker) {
            currentMarker.setLatLng(e.latlng); // Move existing marker
        } else {
            currentMarker = L.marker(e.latlng).addTo(map); // Create a new marker
        }

        displayNearestPlaces(userCoords);
    });

    // Parallax effect for background
    window.addEventListener("scroll", () => {
        const scroll = window.scrollY;
        document.body.style.setProperty("--scroll", scroll);
        document.body.classList.add("scrolled");
    });
</script>
</body>
</html>