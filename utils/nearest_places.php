<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel and Tour Management System</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        /* General Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #333;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #2c3e50;
        }

        p {
            text-align: center;
            font-size: 1.1em;
            color: #7f8c8d;
        }

        #map {
            height: 500px;
            width: 100%;
            margin: 0 auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Package List Styles */
        .package-list {
            margin: 40px auto;
            max-width: 1200px;
        }

        .package-item {
            display: flex;
            background-color: white;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .package-item:hover {
            transform: translateY(-5px);
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.15);
        }

        .package-item img {
            width: 400px;
            height: 250px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        .package-details {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .package-details h3 {
            color: #2980b9;
            font-size: 1.7em;
            margin-bottom: 10px;
        }

        .package-details p {
            font-size: 1.1em;
            color: #555;
            margin-bottom: 5px;
        }

        .package-details p strong {
            color: #2c3e50;
        }

        button,
        a {
            display: inline-block;
            color: white;
            background-color: #3498db; /* Button color */
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: background-color 0.3s ease;
            border: none; /* Remove border from button */
        }

        button:hover,
        a:hover {
            background-color: aquamarine; /* Hover effect */
        }

        @media (max-width: 768px) {
            .package-item {
                flex-direction: column;
                align-items: center;
            }

            .package-item img {
                margin-bottom: 15px;
                width: 100%;
                height: auto;
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
</script>
</body>
</html>
