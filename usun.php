<?php
session_start();

if (!$_SESSION['idk']) {
  header("Location: logowanie.php");
  die;
}

$nazwisko = $_SESSION['nazwisko'];
$katalog = $_SESSION['katalog'];
$folder = $nazwisko . '/' . $katalog;
$plik = $_GET['plik'];
$sciezka = $folder . '/' . $plik;

if(is_dir($sciezka)) {
  if ($handle = opendir($sciezka)) {
    while (false !== ($entry = readdir($handle))) {
      unlink($sciezka . '/' .$entry);
    }
  
    closedir($handle);
  }

  rmdir($sciezka);
} else {
  unlink($sciezka);
}

header("Location: dysk.php");
die;
?>