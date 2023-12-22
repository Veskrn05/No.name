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

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["oc"])) {
    $commentId = $_GET["oc"];


        $stmt_delete_comment = $db->prepare('DELETE FROM komentare WHERE id = ?');
        $stmt_delete_comment->bind_param('i', $commentId);

        if ($stmt_delete_comment->execute()) {
            // Redirect back to the article page after deleting the comment
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit;
        } else {
            echo "Chyba při odstraňování komentáře: " . $stmt_delete_comment->error;
        }

        $stmt_delete_comment->close();
} else {
    echo "Neplatný požadavek na odstranění komentáře.";
}
?>
