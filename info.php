<?php
session_start();
include('prihlaseni/server.php');

// Získat údaje o uživateli
$stmt_select = $db->prepare('SELECT * FROM clanky WHERE id = ?');
$stmt_select->bind_param('i', $_GET['oc']);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$row_user = $result_select->fetch_assoc();
$stmt_select->close();

$stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ?');
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$stmt->bind_result($email, $password, $role, $avatar);
$stmt->fetch();
$stmt->close();

if (empty($row_user)) {
    echo "Článek nenalezen.";
    exit;
}

$nazev = $row_user['nazev'];
$autor = $row_user['autor'];
$obsah = $row_user['obsah'];
$datum = $row_user['datum'];
$fotka = $row_user['fotka'];
$id = $row_user['ID'];
echo "<title>". $nazev ."</title>";
?>

<html>

<head>
    <meta charset="utf-8">
    <title>Filmy</title>
    <link href="https://fonts.cdnfonts.com/css/rawline" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <link rel="stylesheet" type="text/css" href="style.css">
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
            margin: 2rem;
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
            padding: 1.5rem;
            top: 50%;
            margin-bottom: 2rem;
            border-radius: 30px;
            background: #0f0f0f;
            color: white;
            margin-right: auto;
            margin-left: auto;
            text-align: center;
            max-width: 80%;
            margin-top: 3rem;
        }

        .search-box {
            padding: 0 20px 0 0;
            position: relative;
            height: 100%;
            font-size: 14px;
        }

        .search-box input[type="text"] {
            height: 32px;
            padding: 5px 10px;
            letter-spacing: 1px;
            border: 1px solid #CCCCCC;
            font-size: 14px;
            width: 100%;
            background: #1c1c1c;
        }

        .search-box input[type="text"] {
            color: white;
            box-sizing: border-box;
            border-radius: 30px;
            font-family: rawline, sans-serif;
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
            font-weight: bold;
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
            border-bottom: 1px solid white;
        }

        td {
            height: 5rem;
            width: 10rem;
            text-align: center;
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

        #img {
            width: 25rem;
            margin-right: 3rem;
        }

        .vse {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        }

        .druhy {
            max-width: 60%;
            margin-left: 20px;
        }

        #obsah {
            margin-top: 1rem;
            text-align: left;
        }
    </style>
</head>

<body>
    <nav class="navtop">
        <div class="nadpis">
            <div class="cast1">
                <h2 id="logo"><a href="http://veskrna-roman.4fan.cz/casopis/index.php">LOGO</a></h2>
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
                <b><a id="profile" href="profile.php"></b>
                <div id="profile">
                    <?php 
                                if (empty($avatar)) 
                                    echo "<p><b><i id='pctr' class='fas fa-user-circle'></i>" . $_SESSION['username'] . "</b></p>";
                                else
                                    echo "<div id='avatar-container'><img id='avatarimg' src='$avatar' alt='Avatar'></div><p>" . $_SESSION['username'] . "</p>";
                                ?>
                </div>
                </a>
                <?php else: ?>
                <p><b><a href="prihlaseni/login.php">Přihlásit se</a></b></p>
                <?php endif; ?>
            </div>
        </div>
    </nav>
    <div class="hlavni">
        <div class="vse">
            <div id="wrapper">
                <?php echo "<img id='img' src=".$fotka.">";?>
            </div>
            <div class="druhy">
                <table class="table">
                    <tr>
                        <td class="table-left"><b>Název:</b></td>
                        <td class="table-right">
                            <?=$nazev?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-left"><b>Autor:</b></td>
                        <td class="table-right">
                            <?=$autor?>
                        </td>
                    </tr>
                    <tr>
                        <td class="table-left"><b>Datum:</b></td>
                        <td class="table-right">
                            <?=$datum?>
                        </td>
                    </tr>
                </table>

            </div>
        </div>
        <div id="obsah">
            <b>Obsah:</b><br>
            <?=$obsah?>
        </div>
    </div>
    <div style="text-decoration:underline; text-align:center; margin-bottom:2rem;">
            <?php
            if($role =='Administrator'){
                echo "<a style='margin:2rem; font-size:20px;' class='odkaz' href='upravitclanek.php?oc=$id'>Upravit</a>";
            }
            ?>
        </div>
</body>

</html>