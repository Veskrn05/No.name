<?php
session_start();
include('prihlaseni/server.php');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["pridatkoment"])) {
    $komentar = $_POST["pridatkoment"];
    $articleId = $_POST["clanek_id"];

    // Add a new comment to the database
    $stmt_insert_comment = $db->prepare('INSERT INTO komentare (kdo, kdy, idclanku, komentar) VALUES (?, ?, ?, ?)');
    $stmt_insert_comment->bind_param('ssis', $_SESSION['username'], date('Y-m-d H:i:s'), $articleId, $komentar);

    if ($stmt_insert_comment->execute()) {
        // Redirect back to the article page after adding the comment
        header("Location: info.php?oc=$articleId");
        exit;
    } else {
        echo "Chyba při přidávání komentáře: " . $stmt_insert_comment->error;
    }

    $stmt_insert_comment->close();
}
?>
