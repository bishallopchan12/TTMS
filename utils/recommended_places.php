<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel and Tour Management System</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
        .package-list {
            margin-top: 20px;
        }
        .package-item {
            display: flex;
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 10px;
        }
        .package-item img {
            width: 150px;
            height: 100px;
            object-fit: cover;
            margin-right: 10px;
        }
        .package-details {
            display: flex;
            flex-direction: column;
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
    const map = L.map('map').setView([27.7, 85.3], 10); // Centered on Kathmandu

    // Add a tile layer
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    // Simulated dataset of nearby places with coordinates and local images
    const mockPlaces = [
        { 
            name: "Pashupatinath Temple", 
            coordinates: [27.7104, 85.3482], 
            package: "Cultural Tour", 
            image: "../assets/images/pashupatinath.jpg" // Local image path
        },
        { 
            name: "Boudhanath Stupa", 
            coordinates: [27.7215, 85.362], 
            package: "Heritage Tour", 
            image: "../assets/images/boudhanath.jpg" // Local image path
        },
        { 
            name: "Nagarkot", 
            coordinates: [27.7172, 85.5162], 
            package: "Hiking Package", 
            image: "../assets/images/nagarkot.jpg" // Local image path
        },
        { 
            name: "Bhaktapur Durbar Square", 
            coordinates: [27.6722, 85.4285], 
            package: "Historical Tour", 
            image: "../assets/images/bhaktapur.jpg" // Local image path
        },
        { 
            name: "Chandragiri Hills", 
            coordinates: [27.6641, 85.2769], 
            package: "Adventure Package", 
            image: "../assets/images/chandragiri.jpg" // Local image path
        },
        { 
            name: "Patan Durbar Square", 
            coordinates: [27.6731, 85.3242], 
            package: "Cultural Tour", 
            image: "../assets/images/patan.jpg" // Local image path
        },
        { 
            name: "Swayambhunath", 
            coordinates: [27.7149, 85.2905], 
            package: "Religious Tour", 
            image: "../assets/images/swayambhunath.jpg" // Local image path
        }
    ];

    // Function to calculate distance using Haversine formula
    function haversineDistance(coords1, coords2) {
        const toRad = (x) => x * Math.PI / 180;

        let lat1 = coords1[0], lon1 = coords1[1];
        let lat2 = coords2[0], lon2 = coords2[1];

        const R = 6371; // Radius of the Earth in km
        const dLat = toRad(lat2 - lat1);
        const dLon = toRad(lon2 - lon1);

        const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
                  Math.cos(toRad(lat1)) * Math.cos(toRad(lat2)) * 
                  Math.sin(dLon / 2) * Math.sin(dLon / 2);
        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        const distance = R * c; // Distance in km
        return distance;
    }

    // Display nearest places as packages with images
    function displayNearestPlaces(currentLocation) {
        const packageList = document.getElementById('packageList');
        packageList.innerHTML = ''; // Clear previous packages

        // Calculate distances and sort by nearest
        const placesWithDistance = mockPlaces.map(place => {
            const distance = haversineDistance(currentLocation, place.coordinates);
            return { ...place, distance };
        }).sort((a, b) => a.distance - b.distance); // Sort by ascending distance

        // Display top 5 nearest places
        placesWithDistance.slice(0, 5).forEach(place => {
            const packageItem = document.createElement('div');
            packageItem.className = 'package-item';
            packageItem.innerHTML = `
                <img src="${place.image}" alt="${place.name}">
                <div class="package-details">
                    <h3>${place.name}</h3>
                    <p>Package Type: ${place.package}</p>
                    <p>Distance: ${place.distance.toFixed(2)} km</p>
                    <p>Location: ${place.coordinates.join(', ')}</p>
                </div>
            `;
            packageList.appendChild(packageItem);
        });
    }

    // Add marker on map click to set current location
    map.on('click', function(e) {
        const currentLocation = [e.latlng.lat, e.latlng.lng];
        
        // Remove previous marker
        if (map.currentMarker) {
            map.removeLayer(map.currentMarker);
        }

        // Add a marker for the clicked location
        map.currentMarker = L.marker(currentLocation).addTo(map);

        // Display nearest places based on the current location
        displayNearestPlaces(currentLocation);
    });
</script>

</body>
</html>
