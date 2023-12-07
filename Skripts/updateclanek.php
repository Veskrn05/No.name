<?php
session_start();
include('prihlaseni/server.php');

// Zkontrolovat roli uživatele
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

// Získat údaje o článku
$stmt_select = $db->prepare('SELECT nazev, obsah FROM clanky WHERE id = ?');
$stmt_select->bind_param('i', $_GET['oc']);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$row_user = $result_select->fetch_assoc();
$stmt_select->close();

$nazev = $row_user['nazev'];
$obsah = $row_user['obsah'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['submit'])) {
        $newnazev = $_GET['nazev'];
        $newobsah = $_GET['obsah'];

        // Check if there are changes before updating
        if ($newnazev != $nazev || $newobsah != $obsah) {
            // Použití prepared statement pro zabránění SQL injection
            $stmt_update = $db->prepare('UPDATE clanky SET nazev = ?, obsah = ? WHERE id = ?');
            $stmt_update->bind_param('ssi', $newnazev, $newobsah, $_GET['oc']);
            $stmt_update->execute();

            if ($stmt_update->affected_rows > 0) {
                $stmt_update->close();
                session_regenerate_id(true);
                header('Location: seznam.php');
                exit;
            } else {
                echo "Error updating record: " . $stmt_update->error;
            }
            $stmt_update->close();
        } else {
            // No changes, redirect to seznam.php
            header('Location: seznam.php');
            exit;
        }
    }
}
?>
