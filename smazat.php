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

$stmt_delete = $db->prepare('DELETE FROM uzivatele WHERE id = ?');
$stmt_delete->bind_param('i', $_GET['oc']);
$stmt_delete->execute();
$stmt_delete->close();

header('Location: uzivatele.php');
exit;
?>
