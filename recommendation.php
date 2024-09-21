<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Search with Recommendations</title>
    <style>
     
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
        }

        .trip-search-container {
            padding: 2px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 10vh;
            background-color: #f2f2f2;
        }

        .trip-search-form {
            width: 20 px;
            display: flex;
            border: 2px solid #ccc;
            padding: 2px;
            border-radius: 2px;
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
    </style>
</head>
<body>
    <div class="trip-search-container">
        <form class="trip-search-form" class="form-inline">
            <select id="country" class="search-dropdown">
                <option value="Nepal">Nepal</option>
                <!-- You can add more countries if needed -->
            </select>

            <select id="duration" class="search-dropdown">
                <option value="1-7">1 - 7 Days</option>
                <option value="8-14">8 - 14 Days</option>
                <option value="15+">15+ Days</option>
            </select>

            <select id="activities" class="search-dropdown">
                <option value="Trekking">Trekking</option>
                <option value="Wildlife">Wildlife</option>
                <option value="Cultural">Cultural</option>
                <option value="Adventure">Adventure</option>
            </select>

            <select id="season" class="search-dropdown">
                <option value="AllYear">All Year</option>
                <option value="Spring">Spring</option>
                <option value="Summer">Summer</option>
                <option value="Winter">Winter</option>
            </select>

            <button type="button" id="searchBtn">Search</button>
        </form>
    </div>

    <script>
        // Sample trip data
        const trips = [
            { id: 1, name: "Everest Base Camp Trek", duration: "8-14", activities: "Trekking", season: "Spring", rating: 4.9 },
            { id: 2, name: "Chitwan Jungle Safari", duration: "1-7", activities: "Wildlife", season: "Winter", rating: 4.7 },
            { id: 3, name: "Kathmandu Cultural Tour", duration: "1-7", activities: "Cultural", season: "AllYear", rating: 4.5 },
            { id: 4, name: "Annapurna Circuit Trek", duration: "15+", activities: "Trekking", season: "Summer", rating: 4.8 },
            { id: 5, name: "Pokhara Adventure Sports", duration: "1-7", activities: "Adventure", season: "AllYear", rating: 4.6 },
            // Add more trips as needed
        ];

        // Function to recommend trips based on user input
        function recommendTrips(duration, activities, season) {
            const recommendations = trips.filter(trip =>
                (trip.duration === duration || duration === "Any") &&
                (trip.activities === activities || activities === "Any") &&
                (trip.season === season || season === "AllYear")
            );
            return recommendations.sort((a, b) => b.rating - a.rating);
        }

        // Event listener for the search button
        document.getElementById('searchBtn').addEventListener('click', function () {
            const duration = document.getElementById('duration').value;
            const activities = document.getElementById('activities').value;
            const season = document.getElementById('season').value;

            const recommendations = recommendTrips(duration, activities, season);

            if (recommendations.length > 0) {
                let result = 'Recommended Trips:\n';
                recommendations.forEach(trip => {
                    result += `${trip.name} (Rating: ${trip.rating})\n`;
                });
                alert(result);
            } else {
                alert("No trips match your search criteria.");
            }
        });
    </script>
</body>
</html>
