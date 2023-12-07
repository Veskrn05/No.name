<style>
 .pct{
        width: 5rem;
        padding: 0 25px 0 5px;
    }
</style>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
include('prihlaseni/server.php');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

if (isset($_REQUEST["term"])) {
    $sql = "SELECT * FROM clanky WHERE nazev LIKE ?";
    
    $stmt = mysqli_stmt_init($db);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "s", $param_term);
        $param_term = $_REQUEST["term"] . '%';
        
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);
            
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                    $oc = $row['ID'];
                    echo "<a href='info.php?oc=$oc'>" . $row["nazev"] . "</a>";
                }
            } else {
                echo "<p>Žádné výsledky</p>";
            }
        } else {
            echo "ERROR: Could not able to execute $sql. " . mysqli_error($db);
        }
    } else {
        echo "ERROR: Prepare failed: (" . mysqli_errno($db) . ") " . mysqli_error($db);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($db);
?>
