<?php 
  session_start();
  include('prihlaseni/server.php');
  
  // Získání údajů o uživateli pomocí username
  $stmt = $db->prepare('SELECT id, email, password, role, avatar FROM uzivatele WHERE username = ?');
  $stmt->bind_param('s', $_SESSION['username']);
  $stmt->execute();
  $stmt->bind_result($oc, $email, $password, $role, $avatar);
  $stmt->fetch();
  $stmt->close();
  
  // Zobrazení údajů o uživateli
  echo "<title>".$_SESSION['username']."</title>";
  
  if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit;
  }
?>
<html>

<head>
    <meta charset="utf-8">
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

        .nadpis {
            border-bottom: 1px solid #dee0e4;
            color: white;
        }

        .nadpis a {
            text-decoration: underline;
            color: white;
        }

        .hlavni {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
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
          text-decoration: none;
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
 #logo {
            width:10rem;
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
    <strong><a id="profile" href="profile.php">
        <div id="profile">
    <?php 
    if (empty($avatar)) 
        echo "<p><strong><i id='pctr' class='fas fa-user-circle'></i>" . $_SESSION['username'] . "</strong></p>";
    else
        echo "<div id='avatar-container'><img id='avatarimg' src='$avatar' alt='Avatar'></div><p>" . $_SESSION['username'] . "</p>";
    ?>
</div>
<a id="logout" href="logout.php"><i id="pctr1" class="fas fa-sign-out-alt"></i>ODHLÁSIT</a> </p>
            </div>
        </div>
    </nav>
    <div class="content">
      <h2><?=$_SESSION['username']?></h2>
      <div>
        <p>VÁŠ ÚČET</p>
        <table>
          <tr>
            <td>Uživatelské jméno: </td>
            <td><?=$_SESSION['username']?></td>
          </tr>
          <tr>
            <td>Heslo: </td>
            <td><?=$password?></td>
          </tr>
          <tr>
            <td>E-mail: </td>
            <td><?=$email?></td>
          </tr>
          <tr>
            <td>Role: </td>
            <td><?=$role?></td>
          </tr>
        </table>
      </div>
      <a class="file-label" href="upravitprofil.php?oc=<?php echo $oc; ?>">Upravit profil</a>
    <?php
        if (empty($avatar)) {
            echo "<h2>Žádná profilová fotka</h2>";
            echo "<label for='vybrat' class='file-label'>Vybrat soubor</label>";
            echo "<input id='vybrat' type='file' name='avatar' value='' hidden/>";
            echo "<div id='avatar-preview'></div>";
            echo "<button id='uloz' style='display: none;'>Uložit</button>";
            echo "<button id='zrus' style='display: none;'>Zrušit</button>";
        } else {
            echo "<h2>Profilová fotka</h2>";
            echo "<img id='avatar' src='$avatar'><br>";
            echo "<label for='vybrat' class='file-label'>Změnit avatara</label>";
            echo  "<form method='post' action='updatefotky.php' enctype='multipart/form-data'><button type='submit' id='remove' name='remove_avatar'>Odebrat avatara</button></form>";
            echo "<input accept='image/*' id='vybrat' type='file' name='avatar' value='' hidden/>";
            echo "<div id='avatar-preview'></div>";
            echo "<button id='uloz' style='display: none;'>Uložit</button>";
            echo "<button id='zrus' style='display: none;'>Zrušit</button>";
        }
        ?>
        
    </div>
    <script>
        var vybratInput = document.getElementById('vybrat');
        var previewDiv = document.getElementById('avatar-preview');
        var ulozButton = document.getElementById('uloz');
        var zrusButton = document.getElementById('zrus');

        vybratInput.addEventListener('change', function () {
            var input = this;
            var preview = document.getElementById('avatar-preview');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    preview.innerHTML = '<img src="' + e.target.result + '" alt="Náhled obrázku" />';
                    ulozButton.style.display = 'inline-block';
                    ulozButton.style.marginTop = '2rem';
                    zrusButton.style.display = 'inline-block';
                    zrusButton.style.marginTop = '2rem';
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        ulozButton.addEventListener('click', function () {
           
        // Vytvořte FormData objekt pro odeslání souboru
        var formData = new FormData();
        formData.append('avatar', vybratInput.files[0]);

        // Vytvořte nový XMLHttpRequest objekt
        var xhr = new XMLHttpRequest();

        // Nastavte metodu a URL pro požadavek
        xhr.open('POST', 'updatefotky.php', true);

        // Nastavte callback funkci, která se provede po dokončení požadavku
        xhr.onload = function () {
            // Přesměrujte na stránku updatefotky.php
            window.location.href = 'updatefotky.php';
        };

        // Odešlete FormData objekt na server
        xhr.send(formData);
        });

        zrusButton.addEventListener('click', function () {
            vybratInput.value = ''; // Vymazat vybraný soubor
            previewDiv.innerHTML = ''; // Vymazat náhled
            ulozButton.style.display = 'none'; // Schovat tlačítko "Uložit"
            zrusButton.style.display = 'none'; // Schovat tlačítko "Zrušit"
        });
        </script>
        
</body>

</html>