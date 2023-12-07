<?php 
session_start();
  include('server.php');
if (isset($_SESSION['username'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Přihlásit se</title>
<style>
    body {
        background: #1c1c1c;
        color: white;
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    .header {
        background: #0f0f0f;
        text-align: center;
        padding: 20px;
    }

    h2 {
        margin: 1;
        text-align:center;
    }

    form {
        max-width: 300px;
        margin: 0 auto;
        padding: 20px;
        background: #0f0f0f;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        margin-top: 50px;
    }

    .input-group {
        text-align:center;
        margin-bottom: 15px;
    }

    label,
    input {
        display: block;
        width: 96%;
        margin-bottom: 5px;
    }

    input {
        height: 25px;
        padding: 5px;
        border: 1px solid #ccc;
        border-radius: 3px;
    }

   .btn,
.btn1 {
    margin:1rem;
    text-decoration: none;
    padding: 10px;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition-duration: 0.4s;
}

.btn {
    color: #000;
    background: #4caf50;
}

.btn:hover {
    background: #45a049;
}

.btn1 {
    color: black;
    background: #ff4242;
}

.btn1:hover {
    background: #fa2222;
}

    p {
        text-align: center;
        margin-top: 15px;
    }

    a {
        color: #2196f3;
    }

    a:hover {
        color: #0d4caff;
    }
    .error {
  margin: 10px; 
  border: 1px solid #a94442; 
  color: black; 
  background: #ff6d6d; 
  border-radius: 5px; 
}
</style>

</head>
<body>

         
  <form method="post" action="login.php">
      <h2>Přihlásit se</h2>
        <?php include('errors.php'); ?>
        <div class="input-group">
                <label>Uživatelské jméno</label>
                <input type="text" name="username" value="<?php echo $username; ?>">
        </div>
        <div class="input-group">
                <label>Heslo</label>
                <input type="password" name="password">
        </div>
        <div class="input-group">
                <button type="submit" class="btn" name="login_user">Přihlásit se</button>
                <a class="btn1" href="../index.php">Zpět</a>
        </div>
        <p>
                Ještě nemáte účet? <a href="register.php">Registrace</a>
        </p>
  </form>
</body>
</html>