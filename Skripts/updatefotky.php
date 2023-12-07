<?php
session_start();
include('prihlaseni/server.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user wants to remove the avatar
    if (isset($_POST['remove_avatar'])) {
        // Set the avatar column to "NONE"
        $stmt = $db->prepare('UPDATE uzivatele SET avatar = ? WHERE username = ?');
        $emptyString = '';
        $stmt->bind_param('ss', $emptyString, $_SESSION['username']);
        $stmt->execute();
        $stmt->close();

        // Redirect to the profile page
        header('Location: profile.php');
        exit;
    }

    // Handle avatar upload
    // Získání údajů o uživateli pomocí username
    $stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ?');
    $stmt->bind_param('s', $_SESSION['username']);
    $stmt->execute();
    $stmt->bind_result($email, $password, $role, $avatar);
    $stmt->fetch();
    $stmt->close();

    // Adresář pro ukládání avatarů
    $avatarDirectory = 'Avatars/';

    // Získání informací o nahraném souboru
    $fileName = $_FILES['avatar']['name'];
    $fileTmpName = $_FILES['avatar']['tmp_name'];
    $fileType = $_FILES['avatar']['type'];
    $fileSize = $_FILES['avatar']['size'];
    $fileError = $_FILES['avatar']['error'];

    // Kontrola, zda byl soubor nahrán bez chyb
    if ($fileError === 0) {
        // Přesunutí souboru do adresáře pro avatary
        $destination = $avatarDirectory . $fileName;
        move_uploaded_file($fileTmpName, $destination);

        // Aktualizace cesty k avataru v databázi
        $stmt = $db->prepare('UPDATE uzivatele SET avatar = ? WHERE username = ?');
        $stmt->bind_param('ss', $destination, $_SESSION['username']);
        $stmt->execute();
        $stmt->close();

        // Redirect to the profile page
        header('Location: profile.php');
        exit;
    }
    // If no file is uploaded and it's not a removal request, redirect to the profile page
    header('Location: profile.php');
    exit;
}
    header('Location: profile.php');
    exit;
?>
