<?php
session_start();
include('prihlaseni/server.php');

if (isset($_GET['notifikace_id'])) {
    $notifikaceId = $_GET['notifikace_id'];

    // Update the notification status to "read"
    oznacitPrecteno($db, $notifikaceId);

    // Redirect to the original link associated with the notification
    header("Location: info.php?oc=".$notifikaceId);
    exit();
} else {
    // Invalid request, redirect to a default page
    header("Location: index.php");
    exit();
}

function oznacitPrecteno($db, $idOznameni) {
    $stmt = $db->prepare('UPDATE notifikace SET precteno = 1 WHERE id = ?');
    $stmt->bind_param('i', $idOznameni);
    $stmt->execute();
    $stmt->close();
}
?>
