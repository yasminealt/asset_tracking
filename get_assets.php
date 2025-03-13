<?php
include 'config.php';

$query = "SELECT * FROM assets ORDER BY timestamp DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suivi des Actifs</title>
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
    </style>
</head>
<body>
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
            <?php while ($row = $result->fetch_assoc()) { ?>
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
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>
<?php $conn->close(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Actif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
        }
        .message.success {
            color: green;
        }
        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un Actif</h1>
        <?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
            <p class="message success">Actif ajouté avec succès.</p>
        <?php elseif (isset($_GET['status']) && $_GET['status'] == 'error'): ?>
            <p class="message error">Erreur lors de l'ajout de l'actif.</p>
        <?php endif; ?>
        <form action="add_asset.php" method="post">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" required>
            <label for="latitude">Latitude :</label>
            <input type="text" id="latitude" name="latitude" required>
            <label for="longitude">Longitude :</label>
            <input type="text" id="longitude" name="longitude" required>
            <input type="submit" value="Ajouter">
        </form>
        <p><a href="index.php">Voir la liste des actifs</a></p>
    </div>
</body>
</html>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("INSERT INTO assets (name, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $name, $latitude, $longitude);

    if ($stmt->execute()) {
        header("Location: form.html?status=success");
        exit();
    } else {
        header("Location: form.html?status=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("UPDATE assets SET name = ?, latitude = ?, longitude = ? WHERE id = ?");
    $stmt->bind_param("sddi", $name, $latitude, $longitude, $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        header("Location: index.php?status=error");
        exit();
    }

    $stmt->close();
} else {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM assets WHERE id = $id");
    $asset = $result->fetch_assoc();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un Actif</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
            color: #555;
        }
        input[type="text"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 10px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Modifier un Actif</h1>
        <form action="edit_asset.php" method="post">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($asset['id']); ?>">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($asset['name']); ?>" required>
            <label for="latitude">Latitude :</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($asset['latitude']); ?>" required>
            <label for="longitude">Longitude :</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($asset['longitude']); ?>" required>
            <input type="submit" value="Modifier">
        </form>
        <p><a href="index.php">Voir la liste des actifs</a></p>
    </div>
</body>
</html>

<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM assets WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: index.php?status=success");
        exit();
    } else {
        header("Location: index.php?status=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carte des Actifs</title>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY"></script>
    <script>
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 4,
                center: {lat: 0, lng: 0}
            });

            fetch('get_assets.php')
                .then(response => response.json())
                .then(data => {
                    data.forEach(asset => {
                        var marker = new google.maps.Marker({
                            position: {lat: parseFloat(asset.latitude), lng: parseFloat(asset.longitude)},
                            map: map,
                            title: asset.name
                        });
                    });
                })
                .catch(error => console.error('Error fetching asset data:', error));
        }
    </script>
</head>
<body onload="initMap()">
    <div id="map"></div>
</body>
</html>

<?php
include 'config.php';

$query = "SELECT * FROM assets";
$result = $conn->query($query);

$assets = [];
while ($row = $result->fetch_assoc()) {
    $assets[] = $row;
}

echo json_encode($assets);

$conn->close();
?>