<?php
session_start();
include('prihlaseni/server.php');

// Získat údaje o uživateli
$stmt_select = $db->prepare('SELECT * FROM clanky WHERE id = ? ORDER BY datum');
$stmt_select->bind_param('i', $_GET['oc']);
$stmt_select->execute();
$result_select = $stmt_select->get_result();
$row_user = $result_select->fetch_assoc();
$stmt_select->close();

$stmt = $db->prepare('SELECT email, password, role, avatar FROM uzivatele WHERE username = ? ');
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

$stmt_get_ratings = $db->prepare('SELECT hodnoceni FROM hodnoceni WHERE clanek_id = ?');
$stmt_get_ratings->bind_param('i', $articleId);
$stmt_get_ratings->execute();
$result_get_ratings = $stmt_get_ratings->get_result();

$totalRatings = 0;
$numRatings = 0;


while ($row_get_ratings = $result_get_ratings->fetch_assoc()) {
    $totalRatings += $row_get_ratings['hodnoceni'];
    $numRatings++;
}

$stmt_get_ratings->close();
$averageRating = ($numRatings > 0) ? $totalRatings / $numRatings : 0;

$stmt_update_average = $db->prepare('UPDATE clanky SET prumernehodnoceni = ? WHERE id = ?');
$stmt_update_average->bind_param('di', $averageRating, $articleId);
$stmt_update_average->execute();
$stmt_update_average->close();

 $stmt_get_pocet = $db->prepare('SELECT pocetzobrazeni FROM clanky WHERE id = ?');
    $stmt_get_pocet->bind_param('i', $articleId);
    $stmt_get_pocet->execute();
    $stmt_get_pocet->bind_result($currentPocet);
    $stmt_get_pocet->fetch();
    $stmt_get_pocet->close();

    $newPocet = $currentPocet + 1;

    $stmt_update_pocet = $db->prepare('UPDATE clanky SET pocetzobrazeni = ? WHERE id = ?');
    $stmt_update_pocet->bind_param('ii', $newPocet, $articleId);
    $stmt_update_pocet->execute();
    $stmt_update_pocet->close();
    
?>

<html>

<head>
    <meta charset="utf-8">
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

        #logo {
            width:10rem;
        }

        .hlavni {
            padding: 2rem;
            top: 50%;
            margin-bottom: 2rem;
            border-radius: 30px;
            background: #0f0f0f;
            color: white;
            margin-right: auto;
            margin-left: auto;
            text-align: center;
            max-width: 70%;
            margin-top: 3rem;
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
            height: 8rem;
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
            max-width: 25rem;
    border-radius: 10px;
    margin: 2rem;
        }

        .vse {
            display: flex;
    justify-content: flex-start;
    align-items: center;
        }

        .druhy {
            max-width: 60%;
            margin-left: 20px;
            background: #0f0f0f;
    border-radius: 25px;
    min-height: 8rem;
    width: 70%;
    margin: 20px;
    padding: 20px;
    display: flex;
    align-items: center;
        }

        #obsah {
            margin-top: 3rem;
            text-align: justify;
            padding:1rem;
            font-size:18px;
        }
            #obrazek {
max-width: 26rem;
border-radius:10px;
margin:1rem;
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
    .article-container {
    display: flex;
    }

    h1 {
        margin-bottom:1rem;
    }

    #divin{
        flex: 2;
    display: flex;
    text-align: left;
    padding-left: 10px;
    flex-wrap: wrap;
    align-content: space-around;
        flex-direction: column;

    }
    .article {
             background:#0f0f0f;
             border-radius:25px;
             min-height:8rem;
             width:70%;
    margin: 20px;
    padding: 2rem;
    display: flex;
    align-items: center;
    }
    #hacko{
        font-size:24px;
    }
     #obrazek1 {
max-width: 14rem;
border-radius:10px;
margin:2rem;
    }
    /*#pecko{
        margin-top:5rem;
    }*/
.stars {
    border:0;
    display: inline-block;
}

.stars input {
    display: none;
}

.stars label {
    display: inline-block;
    width: 30px;
    height: 30px;
    background-size: cover;
    cursor: pointer;
    transition: transform 0.2s;
}

.stars input:checked + label,
.stars label:not(.empty):hover {
    transform: scale(1.2);
}

.star1 {
    background-image: url('images/star0.png');
}

.star1:not(.empty) {
    background-image: url('images/star1.png');
}
.stars1 {
    border:0;
    display: inline-block;
}

.stars1 input {
    display: none;
}

.stars1 label {
    display: inline-block;
    width: 30px;
    height: 30px;
    background-size: cover;
}
.star {
    background-image: url('images/star0.png');
}

.star:not(.empty) {
    background-image: url('images/star1.png');
}

#tlac{
        cursor:pointer;
        background-color: #0f0f0f;
        color: white;
        border-radius:15px;
        border: 2px solid #4caf50;
        padding: 10px 32px;
        transition-duration: 0.4s;
    }
#tlac:hover{
        background-color: #4caf50;
        color: white;
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
    #becko2{
        margin-right:5px;
        margin-left:2rem;
    }
    #komentare{
        width:100%;
    }
    #odeslat{
        margin-top:1rem;
        text-decoration: none;
    display: flex;
    padding: 8px;
    background-color: #4caf50;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
#odeslat:hover{
    background-color: #45a049;
}
.vsechnykomenty{
    text-align:left;
    margin-top: 1rem;
    border-bottom: 1px solid white;
}
#kdy{
    color: #8d8d8d;
    font-size: 12px;
}
#koment{
    font-size: 16px;
    margin-bottom: 1rem;
    margin-right:2rem;
}
 #be {
        font-weight: bold;
        margin-bottom:1rem;
    }
     #odebirat{
         text-decoration:none;
            margin-left: 1rem;
    font-weight: bold;
    padding: 8px;
    background-color: #4caf50;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
#odebirat:hover{
    background-color: #45a049;
}
 #zrusit{
         text-decoration:none;
            margin-left: 1rem;
    font-weight: bold;
    padding: 8px;
    background-color: #db2c4f;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    }
#zrusit:hover{
    background-color: #b51f3d;
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
#flex{
    display:flex;
    justify-content: space-between;
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
    <div class="hlavni">
            <div class='vse'>
        <div class='article-container'>
        <?php 
        echo "<div id='divimg'><img id='obrazek' src='" . $fotka . "' style='height: auto;'></div>";
echo "<div id='divin'>";
echo "<h1>" . $nazev . "</h1>";
echo "<p id='pecko'><b>Autor:</b> " . $autor;
if($_SESSION['username']!=$autor){
if (isset($_SESSION['username'])) {
    $kdo = $_SESSION['username'];
    $stmt = $db->prepare('SELECT * FROM odbery WHERE kdo = ? AND koho = ?');
    $stmt->bind_param('ss', $kdo, $autor);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();

    if ($result->num_rows > 0) {
        echo "<a href='odber.php?action=cancel&autor=$autor&id=$id' id='zrusit'><i class='fa-solid fa-minus'></i> Zrušit odběr</a>";
    } else {
            echo "<a href='odber.php?action=add&autor=$autor&id=$id' id='odebirat'><i class='fa-solid fa-plus'></i> Odebírat</a>";    }
}
}echo "<b id='datum'>Datum: </b>" . date('d.m.Y', strtotime($datum)) . "</p>";
echo "<p id='druhep'><b id='becko'>Průměrné hodnocení:</b> " . number_format($averageRating, 2) . "<img id='hvezda'src='images/star1.png'></p>";
echo "<p><b id='becko'>Počet hodnocení: </b> " . $numRatings . "<b id='becko2'> Počet zobrazení: </b> " . $newPocet . "</p>";
?>
            </div>
        </div>
        </div>
        <div id="obsah">
   <?= nl2br($obsah) ?>
</div>


<?php if (isset($_SESSION['username'])) : ?>
<?php if ($previousRating == 0): ?>
   <div id="hodnoceni">
      <form method="post" action="hodnoceni.php">
         <label for="hodnoceni"><h3>Ohodnoťte článek:</h3></label>
         <fieldset class="stars" onmouseover="highlightStars(event)" onmouseout="resetStars()" onclick="fillStars()">
            <input type="radio" id="star1" name="hodnoceni" value="1" /><label class="star empty" for="star1" title="1 hvězda"></label>
            <input type="radio" id="star2" name="hodnoceni" value="2" /><label class="star empty" for="star2" title="2 hvězdy"></label>
            <input type="radio" id="star3" name="hodnoceni" value="3" /><label class="star empty" for="star3" title="3 hvězdy"></label>
            <input type="radio" id="star4" name="hodnoceni" value="4" /><label class="star empty" for="star4" title="4 hvězdy"></label>
            <input type="radio" id="star5" name="hodnoceni" value="5" /><label class="star empty" for="star5" title="5 hvězd"></label>
         </fieldset><br>
         <input id="tlac" type="submit" value="Ohodnotit">
         <input type="hidden" name="clanek_id" value="<?= $id ?>">
<script>
      var selectedRating = 0;

      function highlightStars(event) {
         const stars = document.querySelectorAll('.star');
         const hoveredStar = event.target;

         stars.forEach((star, index) => {
            if (star === hoveredStar || star.compareDocumentPosition(hoveredStar) & Node.DOCUMENT_POSITION_FOLLOWING) {
               star.classList.remove('empty');
            } else {
               star.classList.add('empty');
            }
         });
      }

      function resetStars() {
         const stars = document.querySelectorAll('.star');
         stars.forEach((star, i) => {
            if (i < selectedRating) {
               star.classList.remove('empty');
            } else {
               star.classList.add('empty');
            }
         });
      }

      function fillStars() {
         const stars = document.querySelectorAll('.star');
         stars.forEach((star, i) => {
            if (i < selectedRating) {
               star.classList.remove('empty');
            } else {
               star.classList.add('empty');
            }
         });
      }

       document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star');
        const previousRating = <?= isset($previousRating) ? $previousRating : 0; ?>;
        
        stars.forEach((star, i) => {
            if (i < previousRating) {
                star.classList.remove('empty');
            } else {
                star.classList.add('empty');
            }
        });

        stars.forEach((star, i) => {
            star.addEventListener('click', function () {
                selectedRating = i + 1;
                fillStars();
            });
        });
    });
   </script>
<?php else: ?>
         <div id="hodnoceni">
      <form method="post" action="hodnoceni.php">
         <label for="hodnoceni"><h3>Vaše hodnocení</h3></label>
         <fieldset class="stars1">
            <input type="radio" id="star1" name="hodnoceni" value="1" disabled /><label class="star1 empty" for="star1" title="1 stars"></label>
            <input type="radio" id="star2" name="hodnoceni" value="2" disabled /><label class="star1 empty" for="star2" title="2 stars"></label>
            <input type="radio" id="star3" name="hodnoceni" value="3" disabled /><label class="star1 empty" for="star3" title="3 stars"></label>
            <input type="radio" id="star4" name="hodnoceni" value="4" disabled /><label class="star1 empty" for="star4" title="4 stars"></label>
            <input type="radio" id="star5" name="hodnoceni" value="5" disabled /><label class="star1 empty" for="star5" title="5 stars"></label>
         </fieldset><br>
         <script>
      var selectedRating = 0;

      function fillStars() {
         const stars = document.querySelectorAll('.star1');
         stars.forEach((star, i) => {
            if (i < selectedRating) {
               star.classList.remove('empty');
            } else {
               star.classList.add('empty');
            }
         });
      }

       document.addEventListener('DOMContentLoaded', function () {
        const stars = document.querySelectorAll('.star1');
        const previousRating = <?= isset($previousRating) ? $previousRating : 0; ?>;
        
        stars.forEach((star, i) => {
            if (i < previousRating) {
                star.classList.remove('empty');
            } else {
                star.classList.add('empty');
            }
        });

        
    });
   </script>
         <?php endif; ?>
      </form>
   </div>
<?php else: ?>
   <div id="hodnoceni">
      <form method="post" action="hodnoceni.php">
         <label for="hodnoceni"><h3>Pro ohodnocení článku se prosím přihlaste</h3></label>
         <fieldset class="stars">
            <input type="radio" id="star1" name="hodnoceni" value="1" disabled /><label class="star empty" for="star1" title="1 stars"></label>
            <input type="radio" id="star2" name="hodnoceni" value="2" disabled /><label class="star empty" for="star2" title="2 stars"></label>
            <input type="radio" id="star3" name="hodnoceni" value="3" disabled /><label class="star empty" for="star3" title="3 stars"></label>
            <input type="radio" id="star4" name="hodnoceni" value="4" disabled /><label class="star empty" for="star4" title="4 stars"></label>
            <input type="radio" id="star5" name="hodnoceni" value="5" disabled /><label class="star empty" for="star5" title="5 stars"></label>
         </fieldset><br>
      </form>
   </div>
<?php endif; ?>
<div id="komentare">
    <h1>Komentáře</h1>
    <?php if (isset($_SESSION['username'])) : ?>

    <form method="post" action="pridatkomentar.php">
        <textarea style="border-radius: 5px; resize:none; width:100%;font-size: 1rem; height:31px; color:white;font-family: rawline,sans-serif; background-color:#171717;color:white" name="pridatkoment" rows="10" cols="100"></textarea>
        <br>
        <input id="odeslat" type="submit" value="Odeslat komentář">
        <input type="hidden" name="clanek_id" value="<?= $articleId ?>">
    </form>
    <?php else: ?>
    <h3>Pro přidání komentáře se prosím přihlaste</h3>
<?php endif ?>

<?php 
        $stmt_select_comments = $db->prepare('SELECT * FROM komentare WHERE idclanku = ? ORDER BY ID DESC');
$stmt_select_comments->bind_param('i', $articleId);
$stmt_select_comments->execute();
$result_select_comments = $stmt_select_comments->get_result();

if ($result_select_comments->num_rows > 0) {
    while ($row = $result_select_comments->fetch_assoc()) {
        $oc1 = $row["id"];
        echo "<div class='vsechnykomenty'>";
        echo "<div id='kdo'>" . $row["kdo"]."</div>";
    echo "<div  id='kdy'>".(new DateTime($row["kdy"]))->format('d.m.Y H:i') . "</div>";
        echo "<div id='flex'><div id='koment'>" . $row["komentar"] . "</div>";
        if ($role == 'Administrator'||$row["kdo"]==$_SESSION['username']) {
            echo "<a class='odkaz' href='odstranitkomentar.php?oc=$oc1'><b id='be'>Odstranit</b></a>";
        }
        echo "</div>";
        echo "</div>";
    }
} else {
    echo "Zatím zde nejsou žádné komentáře";
}

$stmt_select_comments->close();

?>
        </div>
    </div>
    <div style="text-decoration:underline; text-align:center; margin-bottom:2rem;">
            <?php
            if($role =='Administrator'){
                echo "<a style='margin:2rem; font-size:20px;' class='odkaz' href='upravitclanek.php?oc=$id'>Upravit článek</a>";
            }
            ?>
        </div>
         <div id="celyseznam">
             <h1 style="text-align:center; margin-bottom:2rem;">Nejnovější články</h1>
 <?php
$sql = "SELECT * FROM clanky ORDER BY ID DESC";

$result = $db->query($sql);

if ($result->num_rows > 0) {
    
        while($row = $result->fetch_assoc()) {
            if($nazev!=$row["nazev"]){
            $oc=$row["ID"];
            echo "<div class='all'>";
            echo "<div class='article'>";
            echo "<div id='divimg' ><a class='odkaz' href='info.php?oc=$oc'><img id='obrazek1' src='" . $row["fotka"] . "' style=' height: auto;'></a></div>";
            echo "<div style='flex: 2; padding-left: 10px;'>";
            echo "<h1 id='hacko'><a class='odkaz' href='info.php?oc=$oc'>" . $row["nazev"] . "<a/></h1>";
            echo "<p style='font-size:15px;'>" . substr($row["obsah"], 0, 350) . "...</p>";
            echo "<p><b>Autor:</b> " . $row["autor"] . " <b id='datum'>Datum: </b>" . date('d.m.Y', strtotime($row["datum"]));
            if ($role == 'Administrator') {
                echo "<a class='odkaz' href='upravitclanek.php?oc=$oc'><b id='b'>Upravit článek</b></a>";
            }
            echo "</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        }
    }
} else {
    echo "0 results";
}

$conn->close();
?>
</body>

</html>