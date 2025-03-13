<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $stmt = $conn->prepare("DELETE FROM assets WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: map.php?status=success");
        exit();
    } else {
        header("Location: map.php?status=error");
        exit();
    }

    $stmt->close();
}

$conn->close();
?>