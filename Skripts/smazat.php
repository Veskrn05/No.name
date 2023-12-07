<?php
session_start();
include('prihlaseni/server.php');

$stmt_role = $db->prepare('SELECT role FROM uzivatele WHERE username = ?');
$stmt_role->bind_param('s', $_SESSION['username']);
$stmt_role->execute();
$stmt_role->bind_result($role);
$stmt_role->fetch();
$stmt_role->close();

if ($role != 'Administrator') {
    header('Location: index.php');
    exit;
}

// Získání ID článku, který má být smazán
$idClanku = $_GET['oc'];

// Smazání článku
$stmt_delete = $db->prepare('DELETE FROM clanky WHERE id = ?');
$stmt_delete->bind_param('i', $idClanku);
$stmt_delete->execute();
$stmt_delete->close();

// Smazání všech notifikací souvisejících s tímto článkem
$stmt_delete_notifications = $db->prepare('DELETE FROM notifikace WHERE odkaz = ?');
$odkazClanku = "info.php?oc=$idClanku";
$stmt_delete_notifications->bind_param('s', $odkazClanku);
$stmt_delete_notifications->execute();
$stmt_delete_notifications->close();
if ($stmt_delete_notifications->affected_rows > 0) {
    echo "Notifikace byly úspěšně smazány.";
} else {
    echo "Nepodařilo se smazat žádné notifikace.";
}

?>
