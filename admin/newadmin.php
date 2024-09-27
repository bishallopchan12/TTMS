<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Upload Place Data</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #e9ecef;
            color: #333;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #343a40;
            font-size: 24px;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px 12px;
            margin-bottom: 20px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            background-color: #f8f9fa;
            font-size: 16px;
            transition: border-color 0.3s ease;
        }
        input[type="text"]:focus, textarea:focus {
            border-color: #80bdff;
            outline: none;
        }
        input[type="submit"] {
            width: 100%;
            background-color: #28a745;
            color: #fff;
            padding: 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        #map {
            height: 400px;
            margin-bottom: 20px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
        }
        input[type="file"] {
            font-size: 14px;
            color: #495057;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<h2>Upload Place Data</h2>
<form action="upload_handler.php" method="post" enctype="multipart/form-data">
    <label for="placename">Place Name:</label>
    <input type="text" id="placename" name="placename" required>

    <label for="activities">Activities (comma separated):</label>
    <textarea id="activities" name="activities" rows="3"></textarea>

    <label for="description">Description:</label>
    <textarea id="description" name="description" rows="5"></textarea>

    <label for="map">Select Location on Map:</label>
    <div id="map"></div>
    
    <input type="hidden" id="placelatlong" name="placelatlong">

    <label for="imagesrc">Upload Image:</label>
    <input type="file" id="imagesrc" name="imagesrc" required>

    <input type="submit" value="Upload">
</form>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
<script>
    var map = L.map('map').setView([27.7172, 85.3240], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker;
    function onMapClick(e) {
        var latlng = e.latlng;
        if (marker) {
            marker.setLatLng(latlng);
        } else {
            marker = L.marker(latlng).addTo(map);
        }

        document.getElementById('placelatlong').value = latlng.lat + "," + latlng.lng;
    }

    map.on('click', onMapClick);
</script>

</body>
</html>
