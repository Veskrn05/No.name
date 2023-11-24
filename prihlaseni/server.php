<?php
session_start();
$username = "";
$email    = "";
$errors = array();
$db = mysqli_connect('localhost', '', '', '');


//REGISTRACE-----------------------

if (isset($_POST['reg_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $email = mysqli_real_escape_string($db, $_POST['email']);
  $password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($db, $_POST['password_2']);
  if (empty($username) && empty($email) && empty($password)) {
    array_push($errors, "Vyplňte všechna pole");
  } else {
    if (empty($username) && empty($email)) {
      array_push($errors, "Zadejte uživatelské jméno a e-mail");
    } else {
      if (empty($email) && empty($password)) {
        array_push($errors, "Zadejte e-mail a heslo");
      } else {
        if (empty($username) && empty($password)) {
          array_push($errors, "Zadejte uživatelské jméno a heslo");
        } else {
          if (empty($username)) {
            array_push($errors, "Zadejte uživatelské jméno");
          }
          if (empty($email)) {
            array_push($errors, "Zadejte e-mail");
          }
          if (empty($password_1)) {
            array_push($errors, "Zadejte heslo");
          }
          if ($password_1 != $password_2) {
            array_push($errors, "Hesla se neshodují");
          }
        }
      }
    }
  }
  $user_check_query = "SELECT * FROM uzivatele WHERE username='$username' OR email='$email' LIMIT 1";
  $result = mysqli_query($db, $user_check_query);
  $user = mysqli_fetch_assoc($result);
  if ($user) {
    if ($user['username'] === $username) {
      array_push($errors, "Uživatelské jméno již existuje");
    }

    if ($user['email'] === $email) {
      array_push($errors, "Tento e-mail je již zaregistrován k jinému účtu");
    }
  }
  if (count($errors) == 0) {
    $password = md5($password_1);
    $query = "INSERT INTO uzivatele (username, email, password, role, avatar) VALUES('$username', '$email', '$password', 'Čtenář', '')";
    mysqli_query($db, $query);
    $_SESSION['username'] = $username;
    $_SESSION['success'] = "Jste přihlášeni";
    header('location: ../index.php');
  }
}


//LOGIN---------------------


if (isset($_POST['login_user'])) {
  $username = mysqli_real_escape_string($db, $_POST['username']);
  $password = mysqli_real_escape_string($db, $_POST['password']);
  if (empty($username) && empty($password)) {
    array_push($errors, "Vyplňte všechna pole");
  } else {
    if (empty($username)) {
      array_push($errors, "Zadejte uživatelské jméno");
    }
    if (empty($password)) {
      array_push($errors, "Zadejte heslo");
    }
  }
  if (count($errors) == 0) {
    $password = md5($password);
    $query = "SELECT * FROM uzivatele WHERE username='$username' AND password='$password'";
    $results = mysqli_query($db, $query);
    if (mysqli_num_rows($results) == 1) {
      $_SESSION['username'] = $username;
      $_SESSION['success'] = "Jste přihlášeni";
      header('location: ../index.php');
    } else {
      array_push($errors, "Špatné uživatelské jméno nebo heslo");
    }
  }
}
