<?php
session_start();
include('prihlaseni/server.php');

function pridejNotifikaci($username, $obsah, $odkaz) {
    global $db;

    $stmt = $db->prepare('INSERT INTO notifikace (username, obsah, odkaz, cas, precteno) VALUES (?, ?, ?, NOW(), 0)');
    $stmt->bind_param('sss', $username, $obsah, $odkaz);
    $stmt->execute();
    $stmt->close();
}

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

    $sql = "INSERT INTO clanky (fotka, nazev, autor, obsah, datum, prumernehodnoceni, pocetzobrazeni) VALUES ('$fotoDirectory$fileName', '$nazev', '$_SESSION[username]', '$obsah', NOW(), 0, 0)";

    if (mysqli_query($db, $sql)) {
        // Přidání notifikací pro odběratele
        $novyClanekId = mysqli_insert_id($db); // Získání ID nově vloženého článku

        // Získání seznamu odběratelů
        $stmt = $db->prepare('SELECT kdo FROM odbery WHERE koho = ?');
        $stmt->bind_param('s', $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        while ($row = $result->fetch_assoc()) {
            $odbiratel = $row['kdo'];

            // Přidání notifikace pro každého odběratele
            $obsahNotifikace = "Uživatel $_SESSION[username] vydal nový článek: $nazev";
            $odkazNotifikace = "info.php?oc=$novyClanekId";
            pridejNotifikaci($odbiratel, $obsahNotifikace, $odkazNotifikace);
        }

        mysqli_close($db);
        header('Location: seznam.php');
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($db);
    }
}
?>
