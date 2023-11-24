<?php
session_start();
include('prihlaseni/server.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nazev = $_POST['nazev'];
    $obsah = $_POST['obsah'];

    $fotoDirectory = 'Fotky/';

    $fileName = $_FILES['fotka']['name'];
    $fileTmpName = $_FILES['fotka']['tmp_name'];
    $fileType = $_FILES['fotka']['type'];
    $fileSize = $_FILES['fotka']['size'];
    $fileError = $_FILES['fotka']['error'];
    $destination = $fotoDirectory . $fileName;

    move_uploaded_file($fileTmpName, $destination);

    // Upravený SQL příkaz, který obsahuje plnou cestu k fotce
    $sql = "INSERT INTO clanky (fotka, nazev, autor, obsah, datum) VALUES ('$fotoDirectory$fileName', '$nazev', '$_SESSION[username]', '$obsah', NOW())";

    if (mysqli_query($db, $sql)) {
        mysqli_close($db);
        header('Location: seznam.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}
?>
