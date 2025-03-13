<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte des Actifs</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        table, th, td {
            border: 1px solid #ccc;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #28a745;
            color: #fff;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a, .actions form {
            display: inline-block;
        }
        .actions form {
            margin: 0;
        }
        #map {
            height: 500px;
            width: 100%;
            margin-top: 20px;
        }
    </style>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        function initMap() {
            var map = L.map('map').setView([0, 0], 2);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var assets = <?php
                include 'config.php';
                $query = "SELECT * FROM assets ORDER BY timestamp DESC";
                $result = $conn->query($query);
                $assets = [];
                while ($row = $result->fetch_assoc()) {
                    $assets[] = $row;
                }
                echo json_encode($assets);
                $conn->close();
            ?>;

            assets.forEach(function(asset) {
                if (asset.latitude && asset.longitude) {
                    L.marker([parseFloat(asset.latitude), parseFloat(asset.longitude)])
                        .addTo(map)
                        .bindPopup(asset.name);
                }
            });
        }
    </script>
</head>
<body onload="initMap()">
    <h1>Suivi des Actifs en Temps Réel</h1>
    <p><a href="form.html">Ajouter un nouvel actif</a></p>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Timestamp</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            include 'config.php';
            $query = "SELECT * FROM assets ORDER BY timestamp DESC";
            $result = $conn->query($query);
            while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['id']); ?></td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['latitude']); ?></td>
                <td><?php echo htmlspecialchars($row['longitude']); ?></td>
                <td><?php echo htmlspecialchars($row['timestamp']); ?></td>
                <td class="actions">
                    <a href="edit_asset.php?id=<?php echo $row['id']; ?>">Modifier</a>
                    <form action="delete_asset.php" method="post">
                        <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                        <input type="submit" value="Supprimer">
                    </form>
                    <a href="report.php?id=<?php echo $row['id']; ?>">Voir Rapport</a>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    <div id="map"></div>
</body>
</html>
