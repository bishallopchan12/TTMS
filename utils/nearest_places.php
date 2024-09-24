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

        .package-details a {
            color: #3498db;
            text-decoration: none;
        }

        .package-details a:hover {
            text-decoration: underline;
        }

        .package-details p:last-child {
            margin-top: 10px;
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

    // Mock places data
    const mockPlaces = [
        {
            name: "Pashupatinath Temple",
            coordinates: [27.7104, 85.3482],
            package: "Cultural Tour",
            image: "../assets/images/pashupatinath.jpg",
            description: "One of the most important religious sites for Hindus, the Pashupatinath Temple is located on the banks of the Bagmati River.",
            activities: ["Temple Visit", "Religious Ceremonies", "Meditation"],
            bestTimeToVisit: "October to March",
            duration: "2-3 hours",
            nearbyHotels: ["Hotel Shanker", "Hyatt Regency Kathmandu"],
            entryFee: "NPR 1000 for foreigners, free for SAARC nationals",
            contactInfo: "Phone: +977-1-5521234",
            accessibility: "Easily accessible by car or taxi from Kathmandu city center.",
            website: "http://pashupatinathtemple.gov.np",
            rating: 4.8
        },
        {
            name: "Boudhanath Stupa",
            coordinates: [27.7215, 85.362],
            package: "Heritage Tour",
            image: "../assets/images/boudhanath.jpg",
            description: "A UNESCO World Heritage Site, Boudhanath Stupa is one of the largest spherical stupas in Nepal and a center of Tibetan Buddhism.",
            activities: ["Cultural Walk", "Photography", "Meditation"],
            bestTimeToVisit: "November to February",
            duration: "2 hours",
            nearbyHotels: ["Hotel Tibet International", "Hotel Harmika"],
            entryFee: "NPR 400 for foreigners",
            contactInfo: "Phone: +977-1-5556789",
            accessibility: "Accessible via public transport and taxis from Kathmandu.",
            website: "http://boudhanath.org",
            rating: 4.7
        },
        {
            name: "Nagarkot",
            coordinates: [27.7172, 85.5162],
            package: "Hiking Package",
            image: "../assets/images/nagarkot.jpg",
            description: "Known for its stunning sunrise views of the Himalayas, Nagarkot is a popular hill station near Kathmandu.",
            activities: ["Hiking", "Photography", "Mountain Viewing"],
            bestTimeToVisit: "March to May, September to November",
            duration: "1 day",
            nearbyHotels: ["Hotel Mystic Mountain", "Club Himalaya"],
            entryFee: "Free",
            contactInfo: "Phone: +977-1-4433210",
            accessibility: "Accessible by car, buses, and taxis from Bhaktapur or Kathmandu.",
            website: "http://visitnagarkot.com",
            rating: 4.5
        },
        {
            name: "Phewa Lake",
            coordinates: [28.2096, 83.9595],
            package: "Boating Tour",
            image: "../assets/images/phewa.jpg",
            description: "A serene lake in Pokhara, popular for boating and offering stunning views of the Annapurna mountain range.",
            activities: ["Boating", "Photography", "Fishing", "Lakeside Stroll"],
            bestTimeToVisit: "September to November",
            duration: "2-3 hours",
            nearbyHotels: ["Hotel Barahi", "Fish Tail Lodge"],
            entryFee: "Boat rental fee: NPR 500 per hour",
            contactInfo: "Phone: +977-61-465234",
            accessibility: "Easily accessible from Pokhara city center.",
            website: "http://pokharalake.com",
            rating: 4.6
        },
        {
            name: "Maya Devi Temple",
            coordinates: [27.4712, 83.2756],
            package: "Pilgrimage Tour",
            image: "../assets/images/maya_devi.jpg",
            description: "The Maya Devi Temple is the heart of Lumbini, believed to be the birthplace of Buddha. A UNESCO World Heritage site.",
            activities: ["Temple Visit", "Pilgrimage", "Photography"],
            bestTimeToVisit: "October to February",
            duration: "1-2 hours",
            nearbyHotels: ["Lumbini Garden Lodge", "Buddha Maya Garden Hotel"],
            entryFee: "NPR 500 for foreigners",
            contactInfo: "Phone: +977-71-690410",
            accessibility: "Easily accessible by car from Lumbini town.",
            website: "http://lumbini.gov.np",
            rating: 4.9
        }
    ];

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

    // Function to display nearest places based on user coordinates
    function displayNearestPlaces(userCoords) {
        const nearestPlaces = mockPlaces
            .map((place, index) => ({
                ...place,
                distance: haversineDistance(userCoords, place.coordinates),
            }))
            .sort((a, b) => a.distance - b.distance)
            .slice(0, 5); // Get top 5 nearest places

        const packageList = document.getElementById('packageList');
        packageList.innerHTML = ''; // Clear previous results

        nearestPlaces.forEach((place, index) => {
            const packageItem = document.createElement('div');
            packageItem.classList.add('package-item');

            const packageImage = document.createElement('img');
            packageImage.src = place.image;
            packageItem.appendChild(packageImage);

            const packageDetails = document.createElement('div');
            packageDetails.classList.add('package-details');

            const packageTitle = document.createElement('h3');
            packageTitle.innerText = place.name;

            const packageDescription = document.createElement('p');
            packageDescription.innerText = place.description;

            const packageActivities = document.createElement('p');
            packageActivities.innerHTML = `<strong>Activities:</strong> ${place.activities.join(', ')}`;

            const packageDistance = document.createElement('p');
            packageDistance.innerHTML = `<strong>Distance:</strong> ${(place.distance).toFixed(2)} km`;

            const bookButton = document.createElement('button');
            bookButton.innerText = "Book Now";
            bookButton.onclick = () => bookPlace(index); // Use index as identifier

            packageDetails.appendChild(packageTitle);
            packageDetails.appendChild(packageDescription);
            packageDetails.appendChild(packageActivities);
            packageDetails.appendChild(packageDistance);
            packageDetails.appendChild(bookButton);

            packageItem.appendChild(packageDetails);
            packageList.appendChild(packageItem);
        });
    }

    // Function to handle booking action
    function bookPlace(index) {
        const selectedPlace = mockPlaces[index];
        console.log(`Booking for ${selectedPlace.name}...`);
        alert(`Booking confirmed for ${selectedPlace.name}!`);
        // Here you would typically make an API call to process the booking
    }

    // Event handler for map click
    function onMapClick(e) {
        const userCoords = [e.latlng.lat, e.latlng.lng];
        displayNearestPlaces(userCoords);
    }

    // Add click event to the map
    map.on('click', onMapClick);
</script>
</body>
</html>
