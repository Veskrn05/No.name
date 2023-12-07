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

$idClanku = $_GET['oc'];

$stmt_delete = $db->prepare('DELETE FROM clanky WHERE id = ?');
$stmt_delete->bind_param('i', $idClanku);
$stmt_delete->execute();
$stmt_delete->close();

$stmt_delete_notifications = $db->prepare('DELETE FROM notifikace WHERE odkaz = ?');
$odkazClanku = "info.php?oc=$idClanku";
$stmt_delete_notifications->bind_param('s', $odkazClanku);
$stmt_delete_notifications->execute();
$stmt_delete_notifications->close();

header('Location: seznam.php');
exit;
?>
