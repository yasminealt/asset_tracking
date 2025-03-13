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
    <?php $conn->close(); ?>
</body>
</html>