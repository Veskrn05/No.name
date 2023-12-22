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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Zpracování formuláře po odeslání
    if (isset($_POST['submit'])) {
        // Aktualizace uživatelského jména v databázi
        $newUsername = $_POST['username'];

        $stmt_update = $db->prepare('UPDATE uzivatele SET username = ? WHERE id = ?');
        $stmt_update->bind_param('si', $newUsername, $_GET['oc']);
        $stmt_update->execute();
        $stmt_update->close();

        // Aktualizovat session s novým uživatelským jménem
        $_SESSION['username'] = $newUsername;

        // Přesměrování na seznam uživatelů
        header('Location: profile.php');
        exit;
    }
}
?>

<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM"
        crossorigin="anonymous"></script>

<style>
*{
    color:white;
}
body{
            background: #1c1c1c;

}
    .table{
        width:100%;
            margin-right:auto;
            margin-left:auto;
        }
        .table td{
            vertical-align: top;
            padding:5px;
        }
        .hlavni{
            padding:1.5rem;
        top: 50%;
        margin-bottom:2rem;
        border-radius:30px;
        background: #0f0f0f;
        color:white;
        margin-right:auto;
        margin-left:auto;
        text-align:center;
        max-width:800px;
        margin-top:3rem;
        }
        .hlavni td{
            border-bottom:0px;
        }
        #insertobr{
            padding-bottom:25px;
        }
        .insert{
            width:100%;
            height:30px;
            color:white;
            background:#171717;
            border-radius:5px;
        }
    .ano{
        cursor:pointer;
        background-color: #0f0f0f;
        color: white;
        border-radius:15px;
        border: 2px solid #4caf50;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        transition-duration: 0.4s;
    }
    .ano:hover{
        background-color: #4caf50;
        color: white;
    }
    .zpet{
        cursor:pointer;
        background-color: #0f0f0f;
        color: white;
        border-radius:15px;
        border: 2px solid #f44336;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        transition-duration: 0.4s;
    }
    .zpet:hover{
        background-color: #f44336;
        color: white;
    }
    .modal-content {
    background-color: #1c1c1c;
    }
    .modal-body{
        text-align:center;
    }
    #zpet{
        cursor:pointer;
        color: black;
        border-radius:15px;
        border: 2px solid #f44336;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        transition-duration: 0.4s;
    }
    #zpet:hover{
        background-color: #f44336;
        color: white;
    }
          .file-label {
          margin-top:1rem;
    display: inline-block;
    padding: 8px;
    background-color: #4caf50;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.file-label:hover {
    background-color: #45a049;
}
 #avatar-preview {
            max-width: 300px;
            max-height: 300px;
            margin-top: 10px;
            border:0;
            padding-left:25px;
            margin:0;
        }
        #avatar-preview img{
            max-width: 300px;
            margin:1rem;
            text-align:center;
        }
        #avatar{
            margin-top:10px;
            max-width:300px;
        }
           #uloz,
#zrus {
    margin:1rem;
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition-duration: 0.4s;
}

#uloz {
    color: #000;
    background: #4caf50;
}

#uloz:hover {
    background: #45a049;
}

#zrus {
    color: black;
    background: #ff4242;
}

#zrus:hover {
    background: #fa2222;
}
#remove{
    margin-left:1rem;
    margin-top:1rem;
    text-decoration: none;
    padding: 8px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    color: #000;
    background: #ff4242;
    transition-duration: 0.4s;
}
#remove:hover{
    background: #fa2222;
}
#avatarimg{
    max-width:20px;
    border-radius: 25px;
}
#profile{
    margin-right:10px;
}
</style>
</head>
<body>
     <div class="hlavni">
        <h1>Úprava uživatele <?php echo $row_user['username']; ?></h1>
        <form action="" method="POST">
            <table class="table">
                <tr>
                    <td>Uživatelské jméno:<tr><td><input class="insert" name="username" value="<?php echo $row_user['username']; ?>"></td></tr>
                </tr>
            </table>
            <br>
            <input type="hidden" name="oc" value="<?php echo $_GET['oc']; ?>">
            <input type="submit" name="submit" class="ano" value="Zapiš změny">
            <a class="zpet" href="profile.php">Zpět</a>
        </form>
       <!-- <button id="zpet" class="btn btn-danger" data-toggle="modal" data-target="#myModal">Smazat</button> -->
    </div>
    </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="myModalLabel">Opravdu chcete trvale smazat svůj účet?</h4>
                    </div>
                    <div class="modal-body">
                        <a class="btn btn-danger" href="smazat.php?oc=<?php echo $_GET['oc']; ?>">ANO</a>
        <button type="button" class="btn btn-success" data-dismiss="modal">NE</button>
                </div>
            </div>
        </div>
</body>
</html>