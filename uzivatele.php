<?php 
  session_start();
  include('prihlaseni/server.php');
  $stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ?');
  $stmt->bind_param('s', $_SESSION['username']);
  $stmt->execute();
  $stmt->bind_result($email, $password, $role, $avatar);
  $stmt->fetch();
  $stmt->close();
  
   if($role !='Administrator') {
    header('Location: index.php');
    exit;
}
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
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
            margin-bottom: 2rem;
            border-radius: 30px;
            background: #0f0f0f;
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
#b{
    text-decoration:underline;
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
    <?php
    $sql = "SELECT * FROM uzivatele";
    
    // Provedení SQL dotazu
    $result = $db->query($sql);

    // Zobrazení dat v tabulce
    if ($result->num_rows > 0) {
        echo "<table style='margin-top:2rem; margin-left: auto; margin-right: auto; border-bottom:1px solid white;'>";
        echo "<tr><th>Username</th><th>Email</th><th>Role</th></tr>";
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td style='height:5rem; width:10rem; text-align:center;'>" . $row["username"] . "</td>";
            echo "<td style='height:5rem; width:10rem; text-align:center;'>" . $row["email"] . "</td>";
            echo "<td style='height:5rem; width:10rem; text-align:center;'>" . $row["role"] . "</td>";
            $oc=$row["id"];
            if($role =='Administrator'){
                echo "<td style='height:5rem; width:5rem;' align=center>"."<a class='odkaz' href='upravituzivatele.php?oc=$oc'><b id='b'>Upravit</b></a></td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "0 results";
    }

    // Uzavření spojení s databází
    $conn->close();
    ?>
            ?>
				</tr>
	</div>
</body>

</html>