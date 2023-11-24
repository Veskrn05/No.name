<?php 
  session_start(); 
  include('prihlaseni/server.php');
  // Získání údajů o uživateli pomocí username
  $stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ?');
  $stmt->bind_param('s', $_SESSION['username']);
  $stmt->execute();
  $stmt->bind_result($email, $password, $role, $avatar);
  $stmt->fetch();
  $stmt->close();
  
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

        .nadpis {
            border-bottom: 1px solid #dee0e4;
            color: white;
        }

        .nadpis a {
            text-decoration: underline;
            color: white;
        }

        .hlavni {
            text-align:center;
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

        .result {
            position: absolute;
            border-radius: 15px;
            z-index: 999;
            top: 100%;
            height: 100%;
            font-size: 15px;
        }

        .search-box input[type="text"],
        .result {
            color: white;
            box-sizing: border-box;
            border-radius: 30px;
            font-family: rawline, sans-serif;
        }

        .result a {
            text-decoration: none;
            width: 260px;
            color: white;
            border: 2px solid white;
            border-top: none;
            border-radius: 15px;
            padding: 7px 20px 7px 20px;
            text-align: center;
            height: 100%;
            background: #1c1c1c;
            cursor: pointer;
        }

        .result a:hover {
            border-radius: 15px;
            background: #333232;
            height: 100%;
            text-decoration: underline;
        }

        .result p {
            text-decoration: none;
            width: 260px;
            color: white;
            border: 2px solid white;
            border-top: none;
            border-radius: 15px;
            padding: 7px 20px 7px 20px;
            text-align: center;
            height: 100%;
            background: #1c1c1c;
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

        #tabulka {
            margin-right: auto;
            margin-left: auto;
        }

        .thumbnail {
            height: 110px;
            padding: 10px 0 10px 0;
            width: 75px;
            transition: all ease 0.2s;
        }

        .thumbnail:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 20px 2px rgba(0, 0, 0, 0.25);
        }

        .content {
            width: 1000px;
            margin: 0 auto;
        }

        .content h2 {
            margin: 0;
            padding: 25px 0;
            font-size: 22px;
            border-bottom: 1px solid #e0e0e3;
            color: white;
        }

        .content>p,
        .content>div {
            box-shadow: 0 0 5px 0 rgba(0, 0, 0, 0.1);
            margin: 25px 0;
            padding: 25px;
            background-color: #171717;
            border: 1px solid #e0e0e3;
        }

        .content>p table td,
        .content>div table td {
            padding: 5px;
        }

        .content>p table td:first-child,
        .content>div table td:first-child {
            font-weight: bold;
            color: white;
            padding-right: 15px;
        }

        .content>div p {
            padding: 5px;
            margin: 0 0 10px 0;
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
            margin:0;
            padding:0;
        }
        #avatar-preview img{
            max-width: 300px;
            max-height: 300px;
            margin-top: 1rem;
            margin-bottom:1rem;
        }
        #avatar{
            margin-top:10px;
            max-width:300px;
        }
           #uloz,
#zrus {
    margin-right:1rem;
    margin-top:1rem;
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
    margin-top:1rem;
    text-decoration: none;
    padding: 10px;
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
</div></a>
<?php else: ?>
    <p><b><a href="prihlaseni/login.php">Přihlásit se</a></b></p>
<?php endif; ?>
            </div>
        </div>
    </nav>
<br><br>  
    <div class="hlavni">
	<h1>NEJČTENĚJŠÍ, NEJLÉPE HODNOCENÉ NEBO NEJNOVĚJŠÍ ČLÁNKY</h1>
     </div>
</body>

</html>