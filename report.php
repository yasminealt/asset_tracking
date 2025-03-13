<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "SELECT * FROM asset_history WHERE asset_id = ? ORDER BY timestamp DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $history = [];
    while ($row = $result->fetch_assoc()) {
        $history[] = $row;
    }
    $stmt->close();
    $conn->close();
} else {
    echo "ID de l'actif non spécifié.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rapport d'Historique des Déplacements</title>
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
    </style>
</head>
<body>
    <h1>Rapport d'Historique des Déplacements</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Latitude</th>
                <th>Longitude</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($history as $entry) { ?>
            <tr>
                <td><?php echo htmlspecialchars($entry['id']); ?></td>
                <td><?php echo htmlspecialchars($entry['latitude']); ?></td>
                <td><?php echo htmlspecialchars($entry['longitude']); ?></td>
                <td><?php echo htmlspecialchars($entry['timestamp']); ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>