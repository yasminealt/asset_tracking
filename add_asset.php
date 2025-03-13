<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    $stmt = $conn->prepare("INSERT INTO assets (name, latitude, longitude) VALUES (?, ?, ?)");
    $stmt->bind_param("sdd", $name, $latitude, $longitude);

    if ($stmt->execute()) {
        header("Location: map.php?status=success");
        exit();
    } else {
        header("Location: form.html?status=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>

