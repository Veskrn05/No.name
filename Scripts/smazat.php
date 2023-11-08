 <html>

<head>
    <title>Potvrzení smazání článku</title>
    <style>

body{
        font-family: rawline,sans-serif;
        background: #171717;
        color: white;
    }
        .table {
            vertical-align: top;
            width: 100%;
        }

        .table td {
            vertical-align: top;
            padding: 5px;
text-align: center;
width: 50%;
        }

        .hlavni {
    top: 50%;
    margin-bottom: 2rem;
    border-radius: 30px;
    background: #0f0f0f;
    color: white;
    margin-right: auto;
    margin-left: auto;
    text-align: center;
    max-width: 800px;
    margin-top: 3rem;
padding:20px;
}
        #insertobr {
            padding-bottom: 25px;
        }

        .insert {
            width: 100%;
            height: 30px;
            color: white;
            background: #171717;
        }

        .ano {
            cursor: pointer;
            background-color: #0f0f0f;
            color: white;
            border-radius: 15px;
            border: 2px solid #4caf50;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-right: 100px;
            transition-duration: 0.4s;
        }

        .ano:hover {
            background-color: #4caf50;
            color: white;
        }

        .zpet {
            cursor: pointer;
            background-color: #0f0f0f;
            color: white;
            border-radius: 15px;
            border: 2px solid #f44336;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            transition-duration: 0.4s;
        }

        .zpet:hover {
            background-color: #f44336;
            color: white;
        }

        .content {
            margin: 0 auto;
        }

        .content h2 {
            margin: 0;
            padding: 25px 0;
            font-size: 22px;
            border-bottom: 1px solid #e0e0e3;
            color: white;
        }

        .content>p table td,
        .content>div table td {
            padding: 5px;
        }
    </style>
</head>

<body>
    <div class="hlavni">

        <form action=delete.php method=GET>
            <div class="content">
                <h2>Chcete tento záznam opravdu smazat?</h2><br>
           </div>
            <br>
            <table class="table">
                <input class="ano" type=SUBMIT value="Ano">
        </form>
        <form action=seznam.html>
            <input class="zpet" type=submit value="Zpět">
        </form>
    </div>
</body>

</html>