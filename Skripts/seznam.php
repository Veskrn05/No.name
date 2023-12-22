<?php 
  session_start();
  include('prihlaseni/server.php');
  
  $stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ?');
  $stmt->bind_param('s', $_SESSION['username']);
  $stmt->execute();
  $stmt->bind_result($email, $password, $role, $avatar);
  $stmt->fetch();
  $stmt->close();
  
  if (isset($_GET['oc'])) {
    $articleId = $_GET['oc'];

    $stmt_select_rating = $db->prepare('SELECT hodnoceni FROM hodnoceni WHERE uzivatel = ? AND clanek_id = ?');
    $stmt_select_rating->bind_param('si', $_SESSION['username'], $articleId);
    $stmt_select_rating->execute();
    $result_select_rating = $stmt_select_rating->get_result();
    $row_select_rating = $result_select_rating->fetch_assoc();
    $stmt_select_rating->close();
    
    // Pokud bylo hodnocení nalezeno, získej hodnocení pro zobrazení
    $previousRating = ($row_select_rating) ? $row_select_rating['hodnoceni'] : 0;
  }

  $articleId = $_GET['oc'];

  // Získej hodnocení pro konkrétní článek
  $stmt_get_ratings = $db->prepare('SELECT hodnoceni FROM hodnoceni WHERE clanek_id = ?');
  $stmt_get_ratings->bind_param('i', $articleId);
  $stmt_get_ratings->execute();
  $result_get_ratings = $stmt_get_ratings->get_result();

  $totalRatings = 0;
  $numRatings = 0;

  // Projdi všechna hodnocení pro článek
  while ($row_get_ratings = $result_get_ratings->fetch_assoc()) {
      // Přidej hodnocení k celkovému hodnocení
      $totalRatings += $row_get_ratings['hodnoceni'];
      $numRatings++;
  }

  $stmt_get_ratings->close();

  // Spočítej průměrné hodnocení
  $averageRating = ($numRatings > 0) ? $totalRatings / $numRatings : 0;
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
    #celyseznam{
        margin-top:2rem;
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
                if($role =='Administrator' || $role == 'Autor'){
                echo "<h2 style='padding: 0 0 0 20px;' id='pridatclanek'><a href='http://veskrna-roman.4fan.cz/casopis/pridat.php'>Přidat článek</a></h2>";
            }
            ?>
           <div id="celyseznam">
      <div class="sort">
        <a href="?sort=nejnovejsi" <?php if (!isset($_GET['sort']) || $_GET['sort'] === 'nejnovejsi') echo 'class="active"'; ?>>Nejnovější</a>
        <a href="?sort=nejlepehodnocene" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'nejlepehodnocene') echo 'class="active"'; ?>>Nejlépe hodnocené</a>
        <a href="?sort=nejvicezobrazeni" <?php if (isset($_GET['sort']) && $_GET['sort'] === 'nejvicezobrazeni') echo 'class="active"'; ?>>Nejvíce zobrazení</a>
      </div>
      <?php
      $order = 'ID DESC';

      if (isset($_GET['sort'])) {
          $sort = $_GET['sort'];

          switch ($sort) {
              case 'nejnovejsi':
                  $order = 'ID DESC';
                  break;
              case 'nejlepehodnocene':
                  $order = 'prumernehodnoceni DESC';
                  break;
              case 'nejvicezobrazeni':
                  $order = 'pocetzobrazeni DESC';
                  break;
              default:
                  // If an invalid sorting parameter is provided, revert to the default order
                  $order = 'ID DESC';
          }
      }
      $sql = "SELECT * FROM clanky ORDER BY $order";

      $result = $db->query($sql);

      if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
              $oc = $row["ID"];
              echo "<div class='all'>";
              echo "<div class='article-container'>";
              echo "<div id='divimg' ><a class='odkaz' href='info.php?oc=$oc'><img id='obrazek' src='" . $row["fotka"] . "' style=' height: auto;'></a></div>";
              echo "<div style='flex: 2; padding-left: 10px;'>";
              echo "<h1><a class='odkaz' href='info.php?oc=$oc'>" . $row["nazev"] . "</a></h1>";
              echo "<p style='font-size:15px;'>" . substr($row["obsah"], 0, 350) . "...</p>";
              echo "<p id='druhep'><b id='becko'>Průměrné hodnocení:</b> " . number_format($row["prumernehodnoceni"], 2) . "<img id='hvezda'src='images/star1.png'></p>";
              echo "<p><b>Autor:</b> " . $row["autor"] . " <b id='datum'>Datum: </b>" . date('d.m.Y', strtotime($row["datum"])) ;
              if ($role == 'Administrator') {
                  echo "<a class='odkaz' href='upravitclanek.php?oc=$oc'><b id='b'>Upravit článek</b></a>";
              }
              echo "</p>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
          }
      } else {
          echo "0 results";
      }

      $conn->close();
      ?>
    </div>
  </nav>
</body>

</html>