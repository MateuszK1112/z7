<?php
  session_start();

  if($_SESSION['idk']) {
    header("Location: dysk.php");
    die;
  }
  
  if(count($_POST) > 0) {
    require('connection.php');

    $nazwisko = $_POST['username'];
    $haslo = $_POST['password'];

    $wynik = mysqli_query($connection, "SELECT * FROM klienci WHERE nazwisko LIKE '$nazwisko';");
    $wynik = mysqli_fetch_array($wynik);

    if($wynik) {
      print_r("Użytkownik istnieje!");
    } else {
      mysqli_query($connection, "INSERT INTO klienci VALUES (null, '$nazwisko', '$haslo');");
      mkdir($nazwisko, 0777);
      header("Location: logowanie.php");
      die;
    }
  }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kociszewski</title>
</head>
<body>
  <form method='post'>
    <label>Nazwa użytkownika</label>
    <input type='text' name='username' />
    <br />
    <label>Hasło</label>
    <input type='password' name='password' />
    <br />
    <button type='submit'>Zarejestruj</button>
  </form>
</body>
</html>