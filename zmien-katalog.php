<?php
session_start();

if (!$_SESSION['idk']) {
  header("Location: logowanie.php");
  die;
}

$_SESSION['katalog'] = $_GET['katalog'];

header("Location: dysk.php");
die;
?>