<html>

<head>
    <meta charset="utf-8">
    <title>ČLÁNEK</title>
    <link href="https://fonts.cdnfonts.com/css/rawline" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.2.1/css/all.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
        .pct {
            width: 400px;
            padding: 30px;
        }

        .vse {
            letter-spacing: 1px;
            margin-right: auto;
            margin-left: auto;
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            padding: 20px;
            max-width: 1280px;
            border-radius: 30px;
            background: #0f0f0f;
            display: flex;
        }

        .wrapper {
            float: left;
            width: 50%;

        }

        .druhy {
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            margin-right: auto;
            margin-left: auto;
            float: right;
            width: 50%;
            text-align: center;
        }

        .druhy td {
            text-align: justify;
            vertical-align: top;
            height: 3rem;
            padding: 0 10px;
        }

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

        .databazenadpis {
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
            width: 300px;
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
    </style>
</head>

<body>
    <nav class="navtop">
        <div class="nadpis">
            <div class="cast1">
                <h2 id="logo"><a href="https://alpha.kts.vspj.cz/~veskrn05/RSP/index.html">LOGO</a></h2>
                <h2 id="seznamclanku"><a href="https://alpha.kts.vspj.cz/~veskrn05/RSP/seznam.html">Seznam článků</a>
                </h2>
            </div>
            <div class="cast2">
                <i id="pctr1" class="fa-solid fa-magnifying-glass"></i>
                <form class="search-box">
                    <input type="text" autocomplete="off" placeholder="Vyhledat článek">
                    <div class="result"></div>
                </form>
                <a href="profile.php"><i id="pctr" class='fas fa-user-circle'></i>ADMIN</a>
                <a id=logout href="logout.php"><i id=pctr1 class="fas fa-sign-out-alt"></i>ODHLÁSIT</a>
            </div>
        </div>
    </nav>
    <div class="content">
        <h2>ADMIN</h2>
        <div>
            <p>VÁŠ ÚČET</p>
            <table>
                <tr>
                    <td>Uživatelské jméno: </td>
                    <td>ADMIN</td>
                </tr>
                <tr>
                    <td>Heslo: </td>
                    <td>HESLO</td>
                </tr>
                <tr>
                    <td>E-mail: </td>
                    <td>emailpouzitypriregistraci@gmail.com</td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>