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

        .druhy {
            margin-top: 2.5rem;
            margin-bottom: 2.5rem;
            margin-right: auto;
            margin-left: auto;
            float: right;
            width: 80%;
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
            </div>
        </div>
    </nav>
    <div class="vse">
        <div class="druhy">
            <h1>NÁZEV ČLÁNKU</h1>
            <table class="table">
                <tr>
                    <td>Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Quisque porta. Nullam faucibus mi quis
                        velit. Aliquam erat volutpat. Aliquam erat volutpat. Suspendisse nisl. Nam libero tempore, cum
                        soluta nobis est eligendi optio cumque nihil impedit quo minus id quod maxime placeat facere
                        possimus, omnis voluptas assumenda est, omnis dolor repellendus. Praesent in mauris eu tortor
                        porttitor accumsan. Etiam egestas wisi a erat. Praesent vitae arcu tempor neque lacinia pretium.
                        Proin pede metus, vulputate nec, fermentum fringilla, vehicula vitae, justo. Integer in sapien.
                        Maecenas fermentum, sem in pharetra pellentesque, velit turpis volutpat ante, in pharetra metus
                        odio a lectus. Curabitur bibendum justo non orci.

                        Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia
                        consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Maecenas aliquet accumsan
                        leo. Nullam rhoncus aliquam metus. Sed vel lectus. Donec odio tempus molestie, porttitor ut,
                        iaculis quis, sem. Etiam sapien elit, consequat eget, tristique non, venenatis quis, ante. Nulla
                        accumsan, elit sit amet varius semper, nulla mauris mollis quam, tempor suscipit diam nulla vel
                        leo. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea
                        commodo consequat. Aenean vel massa quis mauris vehicula lacinia. Pellentesque arcu. Vivamus
                        luctus egestas leo. Donec vitae arcu. Fusce aliquam vestibulum ipsum. Integer pellentesque quam
                        vel velit. In enim a arcu imperdiet malesuada. Mauris elementum mauris vitae tortor.

                        Integer tempor. Duis ante orci, molestie vitae vehicula venenatis, tincidunt ac pede. Maecenas
                        sollicitudin. Curabitur sagittis hendrerit ante. In enim a arcu imperdiet malesuada. Etiam dui
                        sem, fermentum vitae, sagittis id, malesuada in, quam. Etiam dictum tincidunt diam. Quis autem
                        vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel
                        illum qui dolorem eum fugiat quo voluptas nulla pariatur? Curabitur bibendum justo non orci. Nam
                        quis nulla. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit
                        laboriosam, nisi ut aliquid ex ea commodi consequatur? Sed vel lectus. Donec odio tempus
                        molestie, porttitor ut, iaculis quis, sem. Aenean fermentum risus id tortor. Sed ut perspiciatis
                        unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam,
                        eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt
                        explicabo. Maecenas sollicitudin. Duis aute irure dolor in reprehenderit in voluptate velit esse
                        cillum dolore eu fugiat nulla pariatur. Pellentesque sapien. Fusce wisi.</td>
                </tr>
            </table>
        </div>
    </div>
    <div style="text-decoration:underline; text-align:center; margin-bottom:2rem;">
        <a style='margin:2rem; font-size:20px;' class='odkaz' href='smazat.php'>Smazat</a><a
            style='margin:2rem; font-size:20px;' class='odkaz' href='upravit.php'>Upravit</a>
    </div>
</body>

</html>