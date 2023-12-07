<?php
session_start();
include('prihlaseni/server.php');

if (isset($_GET['read_notification']) && is_numeric($_GET['read_notification'])) {
    $notificationId = $_GET['read_notification'];
    $stmt_mark_read = $db->prepare('UPDATE notifikace SET precteno = 1 WHERE id = ? AND username = ? AND precteno = 0');
    $stmt_mark_read->bind_param('is', $notificationId, $_SESSION['username']);
    $stmt_mark_read->execute();
    $rows_updated = $stmt_mark_read->affected_rows;
    $stmt_mark_read->close();
    $stmt_get_link = $db->prepare('SELECT odkaz FROM notifikace WHERE id = ?');
    $stmt_get_link->bind_param('i', $notificationId);
    $stmt_get_link->execute();
    $stmt_get_link->bind_result($odkaz);
    $stmt_get_link->fetch();
    $stmt_get_link->close();
    header("Location: $odkaz");
    exit();
}

if (isset($_GET['read_notification1']) && is_numeric($_GET['read_notification1'])) {
    $notificationId = $_GET['read_notification1'];
    $stmt_mark_unread = $db->prepare('UPDATE notifikace SET precteno = 1 WHERE id = ? AND username = ? AND precteno = 0');
    $stmt_mark_unread->bind_param('is', $notificationId, $_SESSION['username']);
    $stmt_mark_unread->execute();
    $rows_updated_unread = $stmt_mark_unread->affected_rows;
    $stmt_mark_unread->close();

    if ($rows_updated_unread > 0) {
        header('Location: notifikace.php');
        exit();
    }
}

if (isset($_GET['unread_notification']) && is_numeric($_GET['unread_notification'])) {
    $notificationId = $_GET['unread_notification'];
    $stmt_mark_unread = $db->prepare('UPDATE notifikace SET precteno = 0 WHERE id = ? AND username = ? AND precteno = 1');
    $stmt_mark_unread->bind_param('is', $notificationId, $_SESSION['username']);
    $stmt_mark_unread->execute();


    $rows_updated_unread = $stmt_mark_unread->affected_rows;
    $stmt_mark_unread->close();

    if ($rows_updated_unread > 0) {
        header('Location: notifikace.php');
        exit();
    }
}

if (isset($_GET['delete_notification']) && is_numeric($_GET['delete_notification'])) {
    $notificationId = $_GET['delete_notification'];
    $stmt_delete_notification = $db->prepare('DELETE FROM notifikace WHERE id = ? AND username = ?');
    $stmt_delete_notification->bind_param('is', $notificationId, $_SESSION['username']);
    $stmt_delete_notification->execute();
    $rows_deleted = $stmt_delete_notification->affected_rows;
    $stmt_delete_notification->close();

    if ($rows_deleted > 0) {
        header('Location: notifikace.php');
        exit();
    }
}

$stmt_notifikace = $db->prepare('SELECT id, obsah, odkaz, precteno, cas FROM notifikace WHERE username = ? ORDER BY cas DESC');
$stmt_notifikace->bind_param('s', $_SESSION['username']);
$stmt_notifikace->execute();
$stmt_notifikace->bind_result($id, $obsah, $odkaz, $precteno, $cas);
$result_notifikace = $stmt_notifikace->get_result();
$stmt_notifikace->close();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>ČASOPIS</title>
    <link href="https://fonts.cdnfonts.com/css/rawline" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        $(document).ready(function () {
            $('.search-box input[type="text"]').on("input", function () {
                var inputVal = $(this).val().trim();
                var resultDropdown = $(this).siblings(".result");
                if (inputVal.length) {
                    $.get("backend-search.php", { term: inputVal }).done(function (data) {
                        resultDropdown.html(data);
                    });
                } else {
                    resultDropdown.empty();
                }
            });
            $(document).on("click", ".result a", function () {
                $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
                $(this).parent(".result").empty();
            });
        });
        $(document).keypress(
            function (event) {
                if (event.which == '13') {
                    event.preventDefault();
                }
            }
        );
    </script>
       <style>
        body {
            font-family: rawline, sans-serif;
            background: #171717;
            color: white;
        }

        .odkaz {
            text-decoration: none;
            color: white;
            text-decoration: underline 0.15em rgba(255, 255, 255, 0);
            transition: text-decoration-color 150ms;
        }

        .odkaz:hover {
            text-decoration-color: rgba(255, 255, 255, 1);
        }

        .nadpis {
            border-bottom: 1px solid #dee0e4;
            color: white;
        }

        .nadpis a {
            text-decoration: underline;
            color: white;
        }

        .logo {
            text-align: left;
        }

        .hlavni {
            padding: 20px;
            max-width: 1200px;
            margin: 2rem auto;
            margin-bottom: 2rem;
            border-radius: 30px;
            background: #0f0f0f;
        }
.hlavni1 {
    border:1px solid white;
            padding: 20px;
            max-width: 1200px;
            margin: 2rem auto;
            margin-bottom: 2rem;
            border-radius: 30px;
            background: #0f0f0f;
        }
       .search-box{
        padding: 0 20px 0 0;
        width: 300px;
        position: relative;
        height:100%;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        letter-spacing: 1px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
        width:100%;
        background: #1c1c1c;
    }
    .result{
        position: absolute; 
        border-radius:15px;
        z-index: 999;
        top: 3rem;
        height:100%;
        font-size:15px;
    }
    .search-box input[type="text"], .result{
        color:white;
        box-sizing: border-box;
        border-radius:5px;
        font-family: rawline,sans-serif;
    }
    .result a{
        text-decoration:none;
        width:260px;
        min-height:60px;
        color:white;
        border:2px solid white;
        /*border-top: none;*/
        border-radius: 5px;
        padding: 7px 20px 7px 20px;
        background: #1c1c1c;
        cursor: pointer;
    }
    .result a:hover{
        background: #333232;
        text-decoration:underline;
    }
    .result p{
        text-decoration:none;
        width:260px;
        color:white;
        top: 100%;
        border:2px solid white;
        /*border-top: none;*/
        border-radius: 5px;
        padding: 7px 20px 7px 20px;
        text-align:center;
        height:25px;
        background: #1c1c1c;
        position: absolute;
    top: -1rem;
    }
    

        .navtop {
            height: 60px;
            width: 100%;
            border: 0;
        }

        .navtop div {
            margin: 0 auto;
            height: 100%;
        }

        .navtop a,
        p {
            text-decoration: none;
        }

        .navtop div h2,
        .navtop div a,
        .navtop div form,
        .navtop div p {
            display: inline-flex;
            align-items: center;
        }

        .navtop div a:hover {
            color: #eaebed;
        }

        .cast1 {
            font-size: 15px;
            padding: 0 0 0 20px;
            float: left;
            display: flex;
            letter-spacing: 1px;
            align-items: center;
            text-transform: uppercase;
        }

        .cast2 {
            letter-spacing: 1px;
            padding: 0 20px 0 0;
            max-width: 50%;
            float: right;
        }

        #seznamclanku {
            padding: 0 0 0 20px;
        }

        #pctr {
            padding: 0 5px 0 0;
        }

        #pctr1 {
            padding: 0 5px 0 0;
        }

        .pridat {
            text-align: center;
        }

        table {
            width: 100%;
            text-align: center;
            margin-left: auto;
            margin-right: auto;
        }

        td {
            height: 5rem;
            width: 10rem;
            text-align: center;
        }

        tr {
            border-bottom: 1px solid white;
        }

        .table-row {
            display: flex;
            justify-content: space-between;
            padding: 2rem;
            border-bottom: 1px solid white;
        }

        .table-left {
            text-align: left;
        }

        .table-right {
            text-align: right;
        }

        #avatarimg {
            width: 50px;
            height: 50px;
            border-radius: 25px;
            vertical-align: middle;
            margin-bottom: 15px;
        }

        #profile {
            margin-right: 10px;
            display: inline-flex;
            justify-content: center;
            align-items: baseline;
        }

        #avatar-container {
            margin-right: 10px;
        }

        #b {
            text-decoration: underline;
        }


        #pridatclanek {
            text-align: center;
            text-decoration: underline;
        }

        #pridatclanek a {
            text-decoration: underline 0.15em rgba(255, 255, 255, 0);
            transition: text-decoration-color 150ms;
            margin: 2rem;
            color: white;
        }

        #pridatclanek a:hover {
            text-decoration-color: rgba(255, 255, 255, 1);

        }

        table b {
            text-decoration: underline;
        }
         .article-container {
             background:#0f0f0f;
             border-radius:25px;
             min-height:8rem;
             width:70%;
    margin: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
    }

    h1 {
        font-size: 24px;
        margin-bottom: 10px;
    }

   
    #obrazek {
max-width: 14rem;
border-radius:10px;
margin:2rem;
    }

    #b {
        font-weight: bold;
        margin-left:2rem;
    }
    #divimg{
        display: flex;
    align-items: center;
    justify-content: center;
    }
    .all{
        display: flex;
    justify-content: center;
    }
    #datum{
        margin-left:2rem;
    }
     #logo {
            width:10rem;
        }
            #hvezda{
        width:25px;
        margin:5px;
    }
    #druhep{
        display:flex;
        align-items: center;
    }
    #becko{
        margin-right:5px;
    }
    .sort{
        display:flex;
        justify-content:center;
    }
   .sort a {
       margin:1rem;
       font-size:20px;
      text-decoration: none;
      color: white;
      text-decoration: underline 0.15em rgba(255, 255, 255, 0);
      transition: text-decoration-color 150ms;
    }

    .sort a:hover {
      text-decoration-color: rgba(255, 255, 255, 1);
    }
     .sort a.active {
      font-weight: bold;
       text-decoration: underline;
       text-decoration-color: rgba(255, 255, 255, 1);
    }
    #nadpis{
        text-align:center;
        font-size:2rem;
    }
    #notifikace{
        display:contents;
    }
    #notifikace .badge {
    background-color: red;
    color: white;
    padding: 1px 5px;
    border-radius: 25px;
    font-size: 9px;
}
#notifikace-dropdown
{
    padding:1rem;
    margin-right:50px;
    border: 2px solid white;
    border-radius: 5px;
    background: rgb(28, 28, 28);
    height: auto;
    position: absolute;
}
#notifikace-dropdown a{
    padding:1px;
}
#notifikace-dropdown a.unread {
        font-weight: bold;
        color: red; /* Můžete změnit barvu pro nepřečtená oznámení podle potřeby */
    }

    #notifikace-dropdown a.read {
        font-weight: normal;
        color: inherit; /* Barva pro přečtená oznámení bude normální barva textu */
    }
    .unread td{
        font-weight:bold
    }
    </style>
</head>

<body>
    <nav class="navtop">
        <div class="nadpis">
            <div class="cast1">
                <a href="http://veskrna-roman.4fan.cz/casopis/index.php"><img id="logo" src="images/logo.png"></a>
                <h2 id="seznamclanku"><a href="http://veskrna-roman.4fan.cz/casopis/seznam.php">Seznam článků</a>
       <?php 
                if($role =='Administrator'){
                echo "<h2 style='padding: 0 0 0 20px;' id='seznamuzivatelu'><a href='http://veskrna-roman.4fan.cz/casopis/uzivatele.php'>Seznam uživatelů</a></h2>";
            }
            ?>
            </div>
            <div class="cast2">
                <i id="pctr1" class="fa-solid fa-magnifying-glass"></i>
                <form class="search-box">
                    <input type="text" autocomplete="off" placeholder="Vyhledat článek">
                    <div class="result"></div>
                </form>
                <?php if (isset($_SESSION['username'])) : ?>
                    <?php
                        $stmt = $db->prepare('SELECT id, obsah, odkaz FROM notifikace WHERE username = ? AND precteno = 0 ORDER BY cas DESC');
                        $stmt->bind_param('s', $_SESSION['username']);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        $stmt->close();
                    ?>
                    <div id="notifikace">
                        <a href="notifikace.php"><i class="fas fa-bell"></i></a>
                        <span class="badge" id="badge"><?php echo $result->num_rows; ?></span>
                    </div>
            <?php endif; ?>
        
                <?php if (isset($_SESSION['username'])) : ?>
    <b><a id="profile" href="profile.php"></b>
        <div id="profile">
    <?php 
    if (empty($avatar)) 
        echo "<p><b><i id='pctr' class='fas fa-user-circle'></i>" . $_SESSION['username'] . "</b></p>";
    else
        echo "<div id='avatar-container'><img id='avatarimg' src='$avatar' alt='Avatar'></div><p>" . $_SESSION['username'] . "</p>";
    ?></div>
</div></a>
<?php else: ?>
    <p><b><a href="prihlaseni/login.php">Přihlásit se</a></b></p>
<?php endif; ?>
            </div>
        </div>
    </nav>
    
        <?php
        
        if ($result_notifikace->num_rows > 0) {
    while ($row_notifikace = $result_notifikace->fetch_assoc()) {
    $prectenoClass = ($row_notifikace['precteno'] == 0) ? 'hlavni1' : 'hlavni';

    echo '<div class="' . $prectenoClass . '">';
    echo '<div id="celyseznam"><table>';
    $prectenoClass = ($row_notifikace['precteno'] == 0) ? 'unread' : 'read';
    $hlavniClass = ($row_notifikace['precteno'] == 0) ? 'hlavni' : 'hlavni1';
    echo '<tr class="' . $prectenoClass . '">';
    echo '<td>' . htmlspecialchars($row_notifikace['obsah']) . '</td>';
    echo '<td><a class="odkaz" href="?read_notification=' . $row_notifikace['id'] . '">Přejít na článek</a></td>';
    
    if ($row_notifikace['precteno'] == 1) {
        echo '<td><a class="odkaz" href="?unread_notification=' . $row_notifikace['id'] . '">Označit jako nepřečtené</a></td>';
    } else {
        echo '<td><a class="odkaz" href="?read_notification1=' . $row_notifikace['id'] . '">Označit jako přečtené</a></td>';
    }
    
    echo '<td><a class="odkaz" href="?delete_notification=' . $row_notifikace['id'] . '">Smazat</a></td>';
    echo "<td>".(new DateTime($row_notifikace['cas']))->format('d.m.Y H:i')."</td>";
    echo '</tr>'; echo '</table></div></div>';
}
           
        } else {
            echo '<p>Žádná oznámení</p>';
        }
        ?>
    
</body>

</html>