<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Route Optimization</title>
    <style>
        /* body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f8;
            color: #333;
            margin: 0;
            padding: 20px;
        } */

        h1 {
            text-align: center;
            color: #0056b3;
            margin-bottom: 20px;
        }

        form {
            max-width: 400px;
            margin: 0 auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }

        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #0056b3;
            color: #ffffff;
            border: none;
            padding: 10px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
            width: 100%;
        }

        input[type="submit"]:hover {
            background-color: #004494;
        }

      

        /* Responsive Design */
        @media (max-width: 600px) {
            form {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <form method="POST">
        <label for="start">Starting Node:</label>
        <select id="start" name="start" required>
    <option value="">Select a place</option>
    <option value="Kathmandu">Kathmandu</option>
    <option value="Bhaktapur">Bhaktapur</option>
    <option value="Patan">Patan</option>
    <option value="Nagarkot">Nagarkot</option>
    <option value="Pokhara">Pokhara</option>
    <option value="Lumbini">Lumbini</option>
    <option value="Ghorepani">Ghorepani</option>
    <option value="Jomsom">Jomsom</option>
    <option value="Chitwan">Chitwan</option>
    <option value="Bandipur">Bandipur</option>
    <option value="Daman">Daman</option>
    <option value="Rara Lake">Rara Lake</option>
    <option value="Gosaikunda">Gosaikunda</option>
    <option value="Manang">Manang</option>
    <option value="Mustang">Mustang</option>
    <option value="Nuwakot">Nuwakot</option>
    <option value="Kirtipur">Kirtipur</option>
    <option value="Dolakha">Dolakha</option>
    <option value="Sindhupalchok">Sindhupalchok</option>
    <option value="Dhulikhel">Dhulikhel</option>
    <option value="Banepa">Banepa</option>
    <option value="Boudhanath">Boudhanath</option>
    <option value="Swayambhunath">Swayambhunath</option>
    <option value="Panauti">Panauti</option>
    <option value="Ilam">Ilam</option>
    <option value="Biratnagar">Biratnagar</option>
    <option value="Jhapa">Jhapa</option>
    <option value="Dharan">Dharan</option>
    <option value="Hetauda">Hetauda</option>
    <option value="Nepalgunj">Nepalgunj</option>
    <option value="Surkhet">Surkhet</option>
    <option value="Palpa">Palpa</option>
    <option value="Tansen">Tansen</option>
    <option value="Baglung">Baglung</option>
    <option value="Rolpa">Rolpa</option>
    <option value="Rukum">Rukum</option>
    <option value="Pyuthan">Pyuthan</option>
    <option value="Dang">Dang</option>
    <option value="Deukhuri">Deukhuri</option>
    <option value="Kapilvastu">Kapilvastu</option>
    <option value="Nawalpur">Nawalpur</option>
    <option value="Sindhuli">Sindhuli</option>
    <option value="Bara">Bara</option>
    <option value="Parsa">Parsa</option>
    <option value="Makwanpur">Makwanpur</option>
    <option value="Kaski">Kaski</option>
    <option value="Syangja">Syangja</option>
    <option value="Lamjung">Lamjung</option>
    <option value="Tanahun">Tanahun</option>
    <option value="Nuwakot">Nuwakot</option>
    <option value="Ramechhap">Ramechhap</option>
    <option value="Kavrepalanchok">Kavrepalanchok</option>
    <option value="Udayapur">Udayapur</option>
    <option value="Okhaldhunga">Okhaldhunga</option>
    <option value="Solukhumbu">Solukhumbu</option>
    <option value="Sankhuwasabha">Sankhuwasabha</option>
    <option value="Bhojpur">Bhojpur</option>
    <option value="Terhathum">Terhathum</option>
    <option value="Dhankuta">Dhankuta</option>
    <option value="Panchthar">Panchthar</option>
    <option value="Taplejung">Taplejung</option>
    <option value="Makalu">Makalu</option>
    <option value="Langtang">Langtang</option>
    <option value="Annapurna Base Camp">Annapurna Base Camp</option>
    <option value="Everest Base Camp">Everest Base Camp</option>
    <option value="Rara National Park">Rara National Park</option>
    <option value="Bardiya National Park">Bardiya National Park</option>
    <option value="Shivalk Hills">Shivalk Hills</option>
    <option value="Phoksumdo Lake">Phoksumdo Lake</option>
    <option value="Janakpur">Janakpur</option>
    <option value="Bardia">Bardia</option>
    <option value="Chame">Chame</option>
    <option value="Sankhu">Sankhu</option>
    <option value="Baneshwor">Baneshwor</option>
    <option value="Patan Durbar Square">Patan Durbar Square</option>
    <option value="Bhaktapur Durbar Square">Bhaktapur Durbar Square</option>
    <option value="Narayanhiti Palace">Narayanhiti Palace</option>
    <option value="Gorkha">Gorkha</option>
    <option value="Lumbini Garden">Lumbini Garden</option>
    <option value="Boudha Stupa">Boudha Stupa</option>
    <option value="Bhimsen Tower">Bhimsen Tower</option>
    <option value="Pashupatinath Temple">Pashupatinath Temple</option>
    <option value="Swayambhu Stupa">Swayambhu Stupa</option>
    <option value="Halesi">Halesi</option>
    <option value="Simraungadh">Simraungadh</option>
    <option value="Kusum Kharka">Kusum Kharka</option>
    <option value="Kakarbhitta">Kakarbhitta</option>
    <option value="Biratnagar Airport">Biratnagar Airport</option>
    <option value="Mahendranagar">Mahendranagar</option>
    <option value="Dhangadhi">Dhangadhi</option>
    <option value="Tikapur">Tikapur</option>
    <option value="Doti">Doti</option>
    <option value="Achham">Achham</option>
    <option value="Bajura">Bajura</option>
    <option value="Kalaiya">Kalaiya</option>
    <option value="Dhangadhi">Dhangadhi</option>
    <option value="Chandragadhi">Chandragadhi</option>
    <option value="Itahari">Itahari</option>
</select>

        <br>

        <label for="destination">Destination Node:</label>
        <select id="destination" name="destination" required>
    <option value="">Select a place</option>
    <option value="Kathmandu">Kathmandu</option>
    <option value="Bhaktapur">Bhaktapur</option>
    <option value="Patan">Patan</option>
    <option value="Nagarkot">Nagarkot</option>
    <option value="Pokhara">Pokhara</option>
    <option value="Lumbini">Lumbini</option>
    <option value="Ghorepani">Ghorepani</option>
    <option value="Jomsom">Jomsom</option>
    <option value="Chitwan">Chitwan</option>
    <option value="Bandipur">Bandipur</option>
    <option value="Daman">Daman</option>
    <option value="Rara Lake">Rara Lake</option>
    <option value="Gosaikunda">Gosaikunda</option>
    <option value="Manang">Manang</option>
    <option value="Mustang">Mustang</option>
    <option value="Nuwakot">Nuwakot</option>
    <option value="Kirtipur">Kirtipur</option>
    <option value="Dolakha">Dolakha</option>
    <option value="Sindhupalchok">Sindhupalchok</option>
    <option value="Dhulikhel">Dhulikhel</option>
    <option value="Banepa">Banepa</option>
    <option value="Boudhanath">Boudhanath</option>
    <option value="Swayambhunath">Swayambhunath</option>
    <option value="Panauti">Panauti</option>
    <option value="Ilam">Ilam</option>
    <option value="Biratnagar">Biratnagar</option>
    <option value="Jhapa">Jhapa</option>
    <option value="Dharan">Dharan</option>
    <option value="Hetauda">Hetauda</option>
    <option value="Nepalgunj">Nepalgunj</option>
    <option value="Surkhet">Surkhet</option>
    <option value="Palpa">Palpa</option>
    <option value="Tansen">Tansen</option>
    <option value="Baglung">Baglung</option>
    <option value="Rolpa">Rolpa</option>
    <option value="Rukum">Rukum</option>
    <option value="Pyuthan">Pyuthan</option>
    <option value="Dang">Dang</option>
    <option value="Deukhuri">Deukhuri</option>
    <option value="Kapilvastu">Kapilvastu</option>
    <option value="Nawalpur">Nawalpur</option>
    <option value="Sindhuli">Sindhuli</option>
    <option value="Bara">Bara</option>
    <option value="Parsa">Parsa</option>
    <option value="Makwanpur">Makwanpur</option>
    <option value="Kaski">Kaski</option>
    <option value="Syangja">Syangja</option>
    <option value="Lamjung">Lamjung</option>
    <option value="Tanahun">Tanahun</option>
    <option value="Nuwakot">Nuwakot</option>
    <option value="Ramechhap">Ramechhap</option>
    <option value="Kavrepalanchok">Kavrepalanchok</option>
    <option value="Udayapur">Udayapur</option>
    <option value="Okhaldhunga">Okhaldhunga</option>
    <option value="Solukhumbu">Solukhumbu</option>
    <option value="Sankhuwasabha">Sankhuwasabha</option>
    <option value="Bhojpur">Bhojpur</option>
    <option value="Terhathum">Terhathum</option>
    <option value="Dhankuta">Dhankuta</option>
    <option value="Panchthar">Panchthar</option>
    <option value="Taplejung">Taplejung</option>
    <option value="Makalu">Makalu</option>
    <option value="Langtang">Langtang</option>
    <option value="Annapurna Base Camp">Annapurna Base Camp</option>
    <option value="Everest Base Camp">Everest Base Camp</option>
    <option value="Rara National Park">Rara National Park</option>
    <option value="Bardiya National Park">Bardiya National Park</option>
    <option value="Shivalk Hills">Shivalk Hills</option>
    <option value="Phoksumdo Lake">Phoksumdo Lake</option>
    <option value="Janakpur">Janakpur</option>
    <option value="Bardia">Bardia</option>
    <option value="Chame">Chame</option>
    <option value="Sankhu">Sankhu</option>
    <option value="Baneshwor">Baneshwor</option>
    <option value="Patan Durbar Square">Patan Durbar Square</option>
    <option value="Bhaktapur Durbar Square">Bhaktapur Durbar Square</option>
    <option value="Narayanhiti Palace">Narayanhiti Palace</option>
    <option value="Gorkha">Gorkha</option>
    <option value="Lumbini Garden">Lumbini Garden</option>
    <option value="Boudha Stupa">Boudha Stupa</option>
    <option value="Bhimsen Tower">Bhimsen Tower</option>
    <option value="Pashupatinath Temple">Pashupatinath Temple</option>
    <option value="Swayambhu Stupa">Swayambhu Stupa</option>
    <option value="Halesi">Halesi</option>
    <option value="Simraungadh">Simraungadh</option>
    <option value="Kusum Kharka">Kusum Kharka</option>
    <option value="Kakarbhitta">Kakarbhitta</option>
    <option value="Biratnagar Airport">Biratnagar Airport</option>
    <option value="Mahendranagar">Mahendranagar</option>
    <option value="Dhangadhi">Dhangadhi</option>
    <option value="Tikapur">Tikapur</option>
    <option value="Doti">Doti</option>
    <option value="Achham">Achham</option>
    <option value="Bajura">Bajura</option>
    <option value="Kalaiya">Kalaiya</option>
    <option value="Dhangadhi">Dhangadhi</option>
    <option value="Chandragadhi">Chandragadhi</option>
    <option value="Itahari">Itahari</option>
</select>
    
        <br>
        <input type="submit" value="Find Shortest Path">
    </form>

    <?php
    // Define the graph as an associative array (same as before)
    $graph = [
        'Kathmandu' => ['Bhaktapur' => 13, 'Patan' => 6, 'Nagarkot' => 30],
        'Bhaktapur' => ['Kathmandu' => 13, 'Patan' => 18, 'Nagarkot' => 22],
        'Patan' => ['Kathmandu' => 6, 'Bhaktapur' => 18, 'Nagarkot' => 28],
        'Nagarkot' => ['Kathmandu' => 30, 'Bhaktapur' => 22, 'Patan' => 28],
        'Pokhara' => ['Kathmandu' => 200, 'Lumbini' => 250, 'Ghorepani' => 50],
        'Lumbini' => ['Pokhara' => 250, 'Kathmandu' => 290],
        'Ghorepani' => ['Pokhara' => 50, 'Jomsom' => 25],
        'Jomsom' => ['Ghorepani' => 25, 'Pokhara' => 75],
        'Chitwan' => ['Kathmandu' => 150, 'Lumbini' => 130, 'Pokhara' => 180],
        'Bandipur' => ['Pokhara' => 70, 'Kathmandu' => 150, 'Daman' => 60],
        'Daman' => ['Kathmandu' => 50, 'Bandipur' => 60, 'Nagarkot' => 70],
        'Rara Lake' => ['Jumla' => 30, 'Surkhet' => 180, 'Nepalgunj' => 200]
    ];

    function dijkstra($graph, $start) {
        $distances = [];
        $priorityQueue = new SplPriorityQueue();

        foreach ($graph as $node => $edges) {
            $distances[$node] = INF;
        }
        $distances[$start] = 0;
        $priorityQueue->insert($start, 0);

        while (!$priorityQueue->isEmpty()) {
            $currentNode = $priorityQueue->extract();

            foreach ($graph[$currentNode] as $neighbor => $weight) {
                $distance = $distances[$currentNode] + $weight;

                if ($distance < $distances[$neighbor]) {
                    $distances[$neighbor] = $distance;
                    $priorityQueue->insert($neighbor, -$distance);
                }
            }
        }

        return $distances;
    }

    // Handle form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $startNode = $_POST['start'];
        $destinationNode = $_POST['destination'];

        // Check if the start node exists in the graph
        if (!array_key_exists($startNode, $graph)) {
            echo "<script>alert('Invalid starting node!');</script>";
        } else {
            $shortestPaths = dijkstra($graph, $startNode);

            // Output the shortest distance to the destination node
            if (array_key_exists($destinationNode, $shortestPaths)) {
                $distance = $shortestPaths[$destinationNode];
                echo "<script>alert('Shortest distance from $startNode to $destinationNode: $distance km');</script>";
            } else {
                echo "<script>alert('Destination node does not exist!');</script>";
            }
        }
    }
    ?>
</body>
</html>
