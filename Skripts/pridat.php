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

if ($role != 'Administrator' && $role != 'Autor') {
    header('Location: index.php');
    exit;
}

?>
<html>

<head>
     <link rel="stylesheet" type="text/css" href="style.css">
    <title>Přidání nového článku</title>
    <style>
    body{
        font-family: rawline, sans-serif;
    background: #171717;
    color: white;
    }
        .table{
            margin-right:auto;
            margin-left:auto;
        }
        .table td{
            vertical-align: top;
            padding:5px;
        }
        .hlavni{
            padding:1rem;
        top: 50%;
        margin-bottom:2rem;
        border-radius:30px;
        background: #0f0f0f;
        color:white;
        margin-right:auto;
        margin-left:auto;
        font-size:30px;
        text-align:center;
        max-width:800px;
        margin-top:2rem;
        min-width:328px;
        }
        .hlavni1{
        top: 50%;
        margin-bottom:2rem;
        border-radius:30px;
        background: #0f0f0f;
        color:white;
        margin-right:auto;
        margin-left:auto;
        font-size:30px;
        text-align:center;
        max-width:800px;
        margin-top:4rem;
        min-width:400px;
        padding: 20px;
        height:553px;
        }
        .scroll {
        overflow: auto;
        text-align: justify;
        padding: 20px;
        max-height:500px;
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
    .pridej{
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
        margin-right:100px;
        transition-duration: 0.4s;
    }
    .pridej:hover{
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
    .oba{
        display:flex;
    }
    .file-label {
    display: inline-block;
    padding: 8px;
    background-color: #4caf50;
    color: black;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 20px;
}

.file-label:hover {
    background-color: #45a049;
}
 #fotka-preview {
            margin-top: 10px;
            border:0;
            margin:0;
            padding:0;
        }
        #fotka-preview img{
            max-width: 300px;
            max-height: 300px;
            margin-top: 1rem;
            margin-bottom:1rem;
        }
        #fotka{
            margin-top:10px;
            max-width:300px;
        }
#zrus {
    margin-top:1rem;
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition-duration: 0.4s;
}

#zrus {
    color: black;
    background: #ff4242;
}

#zrus:hover {
    background: #fa2222;
}


h5{
    margin:1rem;
}
h2{
    margin:1rem;
}
    </style>
</head>

<body>
    <div class="oba">
    <div class="hlavni">
        
        <form action="insert.php" method="POST" enctype="multipart/form-data">
            <table class="table">
                <h2>Přidat nový článek</h2>
                <tr>
                    <td>Název:
                    <tr>
                    <td>
                        <input class="insert" type="text" name="nazev">
                     
                <tr>
                    <td>Obsah:
                    <tr>
                    <td>
                        <textarea class="textarea" style="border-radius: 5px; resize:vertical; width:100%; height:200px; color:white;font-family: rawline,sans-serif; background-color:#171717;color:white" name="obsah" rows="10" cols="100"></textarea>
            </table>
            
            <?php
                            echo "<h5>Fotka</h5>";
                            echo "<label for='vybrat' class='file-label'>Vybrat soubor</label>";
                            echo "<input accept='image/*' id='vybrat' type='file' name='fotka' value='' hidden/>";
                            echo "<div id='fotka-preview'></div>";
                            echo "<label id='zrus' style='display: none;'>Zrušit</label>";
                        ?><br>
            <table class="table">
            <input id="pridej" class="pridej" type="submit" value="Přidej">
        </form>
        <form action="seznam.php" method="GET">
            <input class="zpet" type="submit" value="Zpět">
        </form>
        </table>
        </div>
      
        </div>
        </div>
         <script>
var vybratInput = document.getElementById('vybrat');
var previewDiv = document.getElementById('fotka-preview');
var zrusButton = document.getElementById('zrus');
var pridej = document.getElementById('pridej');

vybratInput.addEventListener('change', function () {
    var input = this;
    var preview = document.getElementById('fotka-preview');

    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            preview.innerHTML = '<img src="' + e.target.result + '" alt="Náhled obrázku" />';
            zrusButton.style.display = 'inline-block';
            zrusButton.style.marginBottom = '2rem';
        };

        reader.readAsDataURL(input.files[0]);
    }
});


zrusButton.addEventListener('click', function () {
    vybratInput.value = '';
    previewDiv.innerHTML = '';
    zrusButton.style.display = 'none';
});
</script>
</body>

</html>