<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advanced Trip Search with Recommendations</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .trip-search-container {
            padding: 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            width: 100vw;  /* 100% of the viewport width */
            box-sizing: border-box;
        }

        .trip-search-form {
            display: flex;
            border: 2px solid #ccc;
            padding: 10px;
            border-radius: 5px;
            background-color: #fff;
        }

        .search-dropdown {
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
        }

        #searchBtn {
            background-color: orange;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        #searchBtn:hover {
            background-color: darkorange;
        }

        .trip-results {
            margin-top: 20px;
            padding: 20px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .trip-card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            width: 300px;
            margin: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .trip-card h3 {
            color: #333;
        }

        .trip-card .rating {
            color: #FFD700;
            font-size: 1.2em;
        }

        .trip-card .duration, .trip-card .price, .trip-card .activities {
            font-size: 1em;
            color: #666;
        }

        .no-results {
            color: #ff0000;
            font-size: 1.2em;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="trip-search-container">
    <form class="trip-search-form">
        <select id="country" class="search-dropdown">
            <option value="Kathmandu">Kathmandu</option>
            <option value="Pokhara">Pokhara</option>
            <option value="Chitwan">Chitwan</option>
            <option value="Lumbini">Lumbini</option>
            <option value="Nagarkot">Nagarkot</option>
            <option value="Dhulikhel">Dhulikhel</option>
            <option value="Gosaikunda">Gosaikunda</option>
            <option value="EverestBaseCamp">Everest Base Camp</option>
            <option value="Annapurna">Annapurna</option>
            <option value="RaraLake">Rara Lake</option>
            <option value="Bandipur">Bandipur</option>
            <option value="Mustang">Mustang</option>
            <option value="Manang">Manang</option>
            <option value="Ilam">Ilam</option>
        </select>

        <select id="duration" class="search-dropdown">
            <option value="1-7">1 - 7 Days</option>
            <option value="8-14">8 - 14 Days</option>
            <option value="15-21">15 - 21 Days</option>
            <option value="22+">22+ Days</option>
        </select>

        <select id="activities" class="search-dropdown">
            <option value="Trekking">Trekking</option>
            <option value="Wildlife">Wildlife</option>
            <option value="Cultural">Cultural</option>
            <option value="Adventure">Adventure</option>
            <option value="Pilgrimage">Pilgrimage</option>
            <option value="Rafting">Rafting</option>
            <option value="MountainBiking">Mountain Biking</option>
            <option value="YogaRetreat">Yoga Retreat</option>
            <option value="Sightseeing">Sightseeing</option>
        </select>

        <select id="season" class="search-dropdown">
            <option value="AllYear">All Year</option>
            <option value="Spring">Spring</option>
            <option value="Summer">Summer</option>
            <option value="Monsoon">Monsoon</option>
            <option value="Autumn">Autumn</option>
            <option value="Winter">Winter</option>
        </select>

        <button type="button" id="searchBtn">Search</button>
    </form>
</div>


    <div class="trip-results" id="tripResults"></div>

    <script>
        // Enhanced trip data with regions and price
    
    // Expanded trip data with 50 trips
    const trips = [
        { id: 1, name: "Everest Base Camp Trek", duration: "8-14", activities: "Trekking", season: "Spring", rating: 4.9, price: 1200, region: "Eastern Nepal" },
        { id: 2, name: "Chitwan Jungle Safari", duration: "1-7", activities: "Wildlife", season: "Winter", rating: 4.7, price: 700, region: "Southern Nepal" },
        { id: 3, name: "Kathmandu Cultural Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.5, price: 300, region: "Central Nepal" },
        { id: 4, name: "Annapurna Circuit Trek", duration: "15+", activities: "Trekking", season: "Summer", rating: 4.8, price: 1500, region: "Western Nepal" },
        { id: 5, name: "Pokhara Adventure Sports", duration: "1-7", activities: "Adventure", season: "AllYear", rating: 4.6, price: 500, region: "Western Nepal" },
        { id: 6, name: "Langtang Valley Trek", duration: "8-14", activities: "Trekking", season: "Summer", rating: 4.5, price: 900, region: "Central Nepal" },
        { id: 7, name: "Poon Hill Sunrise Trek", duration: "1-7", activities: "Trekking", season: "Spring", rating: 4.7, price: 400, region: "Western Nepal" },
        { id: 8, name: "Gosaikunda Lake Pilgrimage", duration: "8-14", activities: "Cultural", season: "Spring", rating: 4.4, price: 600, region: "Central Nepal" },
        { id: 9, name: "Lumbini Buddhist Pilgrimage", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.6, price: 200, region: "Southern Nepal" },
        { id: 10, name: "Upper Mustang Trek", duration: "15+", activities: "Trekking", season: "Summer", rating: 4.9, price: 1800, region: "Western Nepal" },
        { id: 11, name: "Bardia National Park Wildlife Safari", duration: "1-7", activities: "Wildlife", season: "Winter", rating: 4.5, price: 600, region: "Western Nepal" },
        { id: 12, name: "Rara Lake Trek", duration: "8-14", activities: "Trekking", season: "Autumn", rating: 4.8, price: 1000, region: "Western Nepal" },
        { id: 13, name: "Ghorepani Poon Hill Trek", duration: "8-14", activities: "Trekking", season: "Spring", rating: 4.7, price: 800, region: "Western Nepal" },
        { id: 14, name: "Dhulikhel Cultural Village Walk", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.3, price: 150, region: "Central Nepal" },
        { id: 15, name: "Tilicho Lake Trek", duration: "8-14", activities: "Trekking", season: "Autumn", rating: 4.7, price: 1000, region: "Western Nepal" },
        { id: 16, name: "Manaslu Circuit Trek", duration: "15+", activities: "Trekking", season: "Spring", rating: 4.8, price: 1400, region: "Central Nepal" },
        { id: 17, name: "Patan and Bhaktapur Heritage Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.5, price: 250, region: "Central Nepal" },
        { id: 18, name: "Rafting in the Trishuli River", duration: "1-7", activities: "Adventure", season: "Spring", rating: 4.6, price: 300, region: "Central Nepal" },
        { id: 19, name: "Helambu Circuit Trek", duration: "8-14", activities: "Trekking", season: "Winter", rating: 4.4, price: 800, region: "Central Nepal" },
        { id: 20, name: "Dhorpatan Hunting Reserve Adventure", duration: "8-14", activities: "Wildlife", season: "Autumn", rating: 4.3, price: 1200, region: "Western Nepal" },
        { id: 21, name: "Nagarkot Sunrise Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.2, price: 150, region: "Central Nepal" },
        { id: 22, name: "Makalu Base Camp Trek", duration: "15+", activities: "Trekking", season: "Spring", rating: 4.8, price: 1600, region: "Eastern Nepal" },
        { id: 23, name: "Koshi Tappu Wildlife Reserve Safari", duration: "1-7", activities: "Wildlife", season: "Winter", rating: 4.4, price: 600, region: "Eastern Nepal" },
        { id: 24, name: "Bungee Jumping in Bhote Koshi", duration: "1-7", activities: "Adventure", season: "Summer", rating: 4.9, price: 250, region: "Central Nepal" },
        { id: 25, name: "Chisapani Nagarkot Trek", duration: "1-7", activities: "Trekking", season: "AllYear", rating: 4.3, price: 400, region: "Central Nepal" },
        { id: 26, name: "Pikey Peak Trek", duration: "1-7", activities: "Trekking", season: "Spring", rating: 4.7, price: 500, region: "Eastern Nepal" },
        { id: 27, name: "Kanchenjunga Base Camp Trek", duration: "15+", activities: "Trekking", season: "Autumn", rating: 4.9, price: 1800, region: "Eastern Nepal" },
        { id: 28, name: "Janakpur Pilgrimage Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.1, price: 150, region: "Southern Nepal" },
        { id: 29, name: "Khopra Ridge Trek", duration: "8-14", activities: "Trekking", season: "Summer", rating: 4.6, price: 900, region: "Western Nepal" },
        { id: 30, name: "Seti River Rafting", duration: "1-7", activities: "Adventure", season: "Spring", rating: 4.6, price: 350, region: "Western Nepal" },
        { id: 31, name: "Kalinchowk Temple Tour", duration: "1-7", activities: "Cultural", season: "Winter", rating: 4.3, price: 200, region: "Central Nepal" },
        { id: 32, name: "Sundarijal Shivapuri Trek", duration: "1-7", activities: "Trekking", season: "AllYear", rating: 4.4, price: 250, region: "Central Nepal" },
        { id: 33, name: "Sikles Eco-Trek", duration: "1-7", activities: "Trekking", season: "Spring", rating: 4.5, price: 400, region: "Western Nepal" },
        { id: 34, name: "Lower Dolpo Trek", duration: "15+", activities: "Trekking", season: "Autumn", rating: 4.7, price: 1700, region: "Western Nepal" },
        { id: 35, name: "Tansen Historical Town Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.1, price: 150, region: "Western Nepal" },
        { id: 36, name: "Rupa and Begnas Lake Tour", duration: "1-7", activities: "Adventure", season: "Summer", rating: 4.3, price: 200, region: "Western Nepal" },
        { id: 37, name: "Nar Phu Valley Trek", duration: "15+", activities: "Trekking", season: "Spring", rating: 4.9, price: 1600, region: "Western Nepal" },
        { id: 38, name: "Ilam Tea Garden Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.4, price: 200, region: "Eastern Nepal" },
        { id: 39, name: "Phoksundo Lake Trek", duration: "8-14", activities: "Trekking", season: "Autumn", rating: 4.8, price: 1300, region: "Western Nepal" },
        { id: 40, name: "Rasuwa Tamang Heritage Trek", duration: "1-7", activities: "Trekking", season: "AllYear", rating: 4.3, price: 600, region: "Central Nepal" },
        { id: 41, name: "Panchase Trek", duration: "1-7", activities: "Trekking", season: "Spring", rating: 4.4, price: 300, region: "Western Nepal" },
        { id: 42, name: "Daman Hill Station Tour", duration: "1-7", activities: "Cultural", season: "Winter", rating: 4.2, price: 180, region: "Central Nepal" },
        { id: 43, name: "Upper Dolpo Trek", duration: "15+", activities: "Trekking", season: "Summer", rating: 4.9, price: 2000, region: "Western Nepal" },
        { id: 44, name: "Jomsom Muktinath Trek", duration: "8-14", activities: "Trekking", season: "Autumn", rating: 4.7, price: 900, region: "Western Nepal" },
        { id: 45, name: "Hiking to Namobuddha Monastery", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.3, price: 150, region: "Central Nepal" },
        { id: 46, name: "Mt. Kanjiroba Expedition", duration: "15+", activities: "Trekking", season: "Spring", rating: 4.8, price: 2200, region: "Western Nepal" },
        { id: 47, name: "Sailung Trek", duration: "8-14", activities: "Trekking", season: "Spring", rating: 4.6, price: 800, region: "Central Nepal" },
        { id: 48, name: "Mardi Himal Trek", duration: "8-14", activities: "Trekking", season: "Autumn", rating: 4.8, price: 700, region: "Western Nepal" },
        { id: 49, name: "Rupina La Pass Trek", duration: "15+", activities: "Trekking", season: "Autumn", rating: 4.7, price: 1500, region: "Central Nepal" },
        { id: 50, name: "Kapilvastu Cultural Heritage Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.2, price: 180, region: "Southern Nepal" }
    ];



        // Recommend trips based on user input with enhanced filtering and sorting
        function recommendTrips(duration, activities, season) {
            return trips.filter(trip =>
                (trip.duration === duration || duration === "Any") &&
                (trip.activities === activities || activities === "Any") &&
                (trip.season === season || season === "AllYear")
            ).sort((a, b) => b.rating - a.rating);
        }

        // Display trip recommendations dynamically
        function displayTrips(trips) {
            const tripResults = document.getElementById("tripResults");
            tripResults.innerHTML = ""; // Clear previous results

            if (trips.length === 0) {
                tripResults.innerHTML = '<div class="no-results">No trips match your search criteria.</div>';
            } else {
                trips.forEach(trip => {
                    tripResults.innerHTML += `
                        <div class="trip-card">
                            <h3>${trip.name}</h3>
                            <div class="rating">Rating: ★${trip.rating}</div>
                            <div class="duration">Duration: ${trip.duration} Days</div>
                            <div class="activities">Activities: ${trip.activities}</div>
                            <div class="price">Price: Rs${trip.price}</div>
                        </div>
                    `;
                });
            }
        }

        // Event listener for the search button
        document.getElementById('searchBtn').addEventListener('click', function () {
            const duration = document.getElementById('duration').value;
            const activities = document.getElementById('activities').value;
            const season = document.getElementById('season').value;

            const recommendations = recommendTrips(duration, activities, season);
            displayTrips(recommendations);
        });
    </script>
</body>
</html>
