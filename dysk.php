<?php
session_start();

if (!$_SESSION['idk']) {
  header("Location: logowanie.php");
  die;
}

require('connection.php');

$mojeId = $_SESSION['idk'];
$nazwisko = $_SESSION['nazwisko'];
$katalog = $_SESSION['katalog'];

if ($_POST['katalog']) {
  $nazwa = $_POST['katalog'];
  $nazwa = strtolower(trim(str_replace(" ", "__", $nazwa)));

  mkdir($nazwisko . '/' . $nazwa, 0777, true);
}

$wynik = mysqli_query($connection, "select * FROM logi WHERE idk = '$mojeId' AND sukces = 0 ORDER by datagodzina DESC LIMIT 1;");
$wynik = mysqli_fetch_array($wynik);
$files = array();

if ($handle = opendir($nazwisko . '/' . $katalog)) {
  while (false !== ($entry = readdir($handle))) {
    $files[] = $entry;
  }

  closedir($handle);
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kociszewski</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
  <a href='wylogowanie.php'>Wyloguj</a><br />
  <a href='select.php'>Wgraj</a>

  <p style="color: red;"><?php echo $wynik['datagodzina']; ?> - ostatnie błędne logowanie</p>

  <?php if (!$katalog) : ?>
    <form method='post'>
      Nazwa katalogu<br>
      <input type='text' name="katalog" />

      <button type='submit'>Utwórz katalog</button>
    </form>
  <?php endif; ?>

  <div style='display:flex;flex-direction:row;flex-wrap:wrap;'>
    <?php if ($katalog) : ?>
      <a href="zmien-katalog.php?katalog=">
        <i class="fas fa-arrow-circle-left fa-3x"></i>
      </a>
    <?php endif; ?>

    <?php foreach ($files as $file) : ?>
      <?php if (!in_array($file, array('.', '..'))) : ?>
        <div style='padding:12px;'>
          <?php $sciezka = $nazwisko . '/' . $katalog . '/' . $file; ?>

          <?php if (is_file($sciezka)) : ?>
            <i class="fas fa-file fa-3x"></i><br />
            <a href="<?php echo $sciezka; ?>" download><?php echo $file; ?></a>
          <?php else : ?>
            <i class="fas fa-folder fa-3x"></i><br />
            <a href="zmien-katalog.php?katalog=<?php echo $file; ?>"><?php echo $file; ?></a>
          <?php endif; ?>
          <br />
          <a href="usun.php?plik=<?php echo $file; ?>">
            <i class="fas fa-trash"></i>
          </a>
        </div>
      <?php endif; ?>
    <?php endforeach; ?>
  </div>
</body>

</html>