<?php
session_start();

if ($_SESSION['idk']) {
  header("Location: dysk.php");
  die;
}

if (count($_POST) > 0) {
  require('connection.php');

  $nazwisko = $_POST['username'];
  $haslo = $_POST['password'];

  $wynik = mysqli_query($connection, "SELECT * FROM klienci WHERE nazwisko LIKE '$nazwisko';");
  $wynik = mysqli_fetch_array($wynik);

  $datagodzina = date('Y-m-d H:i:s');
  $ip = $_SERVER['REMOTE_ADDR'];
  $przegladarka = $_SERVER['HTTP_USER_AGENT'];

  if (!$wynik) {
    print_r("Błędny login i/lub hasło :(");
  } else {
    $sukces = $wynik && $wynik['haslo'] == $haslo;
    $mojeId = $wynik['idk'];

    $wynik2 = mysqli_query($connection, "SELECT count(*) = 3 as bledy FROM (select * FROM `logi` WHERE idk = $mojeId ORDER by datagodzina DESC LIMIT 3) as ostatnie WHERE ostatnie.sukces = 0");
    $wynik2 = mysqli_fetch_array($wynik2);

    if ($wynik2['bledy'] == 1) {
      $wynik3 = mysqli_query($connection, "SELECT timestampdiff(SECOND, datagodzina, now()) < 61 as roznica FROM logi WHERE sukces = 0 AND idk = $mojeId ORDER BY datagodzina DESC LIMIT 1");
      $wynik3 = mysqli_fetch_array($wynik3);

      if ($wynik3['roznica'] == 1) {
        echo "Logowanie zablokowane";
        die;
      }
    }

    if (!$sukces) {
      mysqli_query($connection, "INSERT INTO logi VALUES (null, {$wynik['idk']}, '$datagodzina', '$ip', '$przegladarka', 0);");
      print_r("Błędny login i/lub hasło :(");
    } else {
      $_SESSION['idk'] = $wynik['idk'];
      $_SESSION['nazwisko'] = $wynik['nazwisko'];

      mysqli_query($connection, "INSERT INTO logi VALUES (null, {$wynik['idk']}, '$datagodzina', '$ip', '$przegladarka', 1);");
      header("Location: dysk.php");
      die;
    }
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
    <button type='submit'>Zaloguj</button>
  </form>
</body>

</html>