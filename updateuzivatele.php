<?php
session_start();
include('prihlaseni/server.php');

// Zkontrolovat roli uživatele
$stmt_role = $db->prepare('SELECT role, id FROM uzivatele WHERE username = ?');
$stmt_role->bind_param('s', $_SESSION['username']);
$stmt_role->execute();
$stmt_role->bind_result($role, $currentUserId);
$stmt_role->fetch();
$stmt_role->close();

if ($role != 'Administrator') {
    header('Location: index.php');
    exit;
}

// Získat údaje o uživateli
$stmt_select = $db->prepare('SELECT * FROM uzivatele WHERE id = ?');
$stmt_select->bind_param('i', $_GET['oc']);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$row_user = $result_select->fetch_assoc();
$stmt_select->close();

echo "<title>Úprava uživatele " . $_SESSION['username'] . "</title>";

if (empty($row_user)) {
    echo "Uživatel nenalezen.";
    exit;
}

$username = $row_user['username'];
$email = $row_user['email'];
$role = $row_user['role'];
$editedUserId = $row_user['id'];

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Zpracování formuláře po odeslání
    if (isset($_GET['submit'])) {
        // Aktualizace údajů v databázi
        $newUsername = $_GET['username'];
        $newRole = $_GET['role'];

        $stmt_update = $db->prepare('UPDATE uzivatele SET username = ?, role = ? WHERE id = ?');
        $stmt_update->bind_param('ssi', $newUsername, $newRole, $editedUserId);
        $stmt_update->execute();
        $stmt_update->close();

        // Aktualizovat session s novými údaji, pouze pokud upravujete svůj vlastní účet
        if ($editedUserId == $currentUserId || empty($editedUserId)) {
            $_SESSION['username'] = $newUsername;
            $_SESSION['role'] = $newRole;
            
            // Znovu načíst session data s novým ID
            session_regenerate_id(true);
        }

        // Přesměrování na seznam uživatelů
        header('Location: uzivatele.php');
        exit;
    }
}
?>
