<?php
session_start();
include('prihlaseni/server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userLoggedIn = isset($_SESSION['username']) ? $_SESSION['username'] : null;
    $articleId = isset($_POST['clanek_id']) ? $_POST['clanek_id'] : null;
    $hodnoceni = isset($_POST['hodnoceni']) ? $_POST['hodnoceni'] : null;

    $stmt_check = $db->prepare('SELECT * FROM hodnoceni WHERE uzivatel = ? AND clanek_id = ?');
    $stmt_check->bind_param('si', $_SESSION['username'], $articleId);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows == 0) {
        $stmt_insert = $db->prepare('INSERT INTO hodnoceni (uzivatel, clanek_id, hodnoceni) VALUES (?, ?, ?)');
        $stmt_insert->bind_param('sid', $_SESSION['username'], $articleId, $hodnoceni);
        $stmt_insert->execute();
    }

    $stmt_check->close();
    $stmt_insert->close();

    // Přesměrování na stránku s informacemi o článku
    header('Location: info.php?oc=' . $articleId);
    exit;
}

// Přesměrování v případě, že POST data nejsou dostupná
header('Location: seznam.php');
exit;

$db->close();
?>
