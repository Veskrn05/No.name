<?php
// Připojení k databázi a zahájení relace
session_start();
require('prihlaseni/server.php');
function addSubscription($kdo, $koho) {
    global $db;
    $stmt = $db->prepare('INSERT INTO odbery (kdo, koho) VALUES (?, ?)');
    $stmt->bind_param('ss', $kdo, $koho);
    $stmt->execute();
    $stmt->close();
}

// Funkce pro zrušení odběru
function cancelSubscription($kdo, $koho) {
    global $db;
    $stmt = $db->prepare('DELETE FROM odbery WHERE kdo = ? AND koho = ?');
    $stmt->bind_param('ss', $kdo, $koho);
    $stmt->execute();
    $stmt->close();
}
if (isset($_GET['id']))
    $id = $_GET['id'];
if (isset($_GET['action']) && isset($_GET['autor'])) {
    $action = $_GET['action'];
    $autor = $_GET['autor'];

    if (isset($_SESSION['username'])) {
        $kdo = $_SESSION['username'];

        if ($action === 'add') {
            // Přidat odběr
            addSubscription($kdo, $autor);
        } elseif ($action === 'cancel') {
            // Zrušit odběr
            cancelSubscription($kdo, $autor);
        }
    }
}

// Přesměrování zpět na info.php
header('Location: info.php?oc='.$id);
exit();
?>