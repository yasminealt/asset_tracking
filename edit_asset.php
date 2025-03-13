<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM assets WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $asset = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "ID de l'actif non spécifié.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("UPDATE assets SET name = ?, latitude = ?, longitude = ? WHERE id = ?");
    $stmt->bind_param("sddi", $name, $latitude, $longitude, $id);

    if ($stmt->execute()) {
        header("Location: map.php?status=success");
        exit();
    } else {
        header("Location: edit_asset.php?id=$id&status=error");
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
        <form action="edit_asset.php?id=<?php echo htmlspecialchars($id); ?>" method="post">
            <label for="name">Nom :</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($asset['name']); ?>" required>
            <label for="latitude">Latitude :</label>
            <input type="text" id="latitude" name="latitude" value="<?php echo htmlspecialchars($asset['latitude']); ?>" required>
            <label for="longitude">Longitude :</label>
            <input type="text" id="longitude" name="longitude" value="<?php echo htmlspecialchars($asset['longitude']); ?>" required>
            <input type="submit" value="Modifier">
        </form>
        <p><a href="map.php">Retour à la liste des actifs</a></p>
    </div>
</body>
</html>