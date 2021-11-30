<?php
session_start();

if (!$_SESSION['idk']) {
  header("Location: logowanie.php");
  die;
}

$nazwisko = $_SESSION['nazwisko'];
$katalog = $_SESSION['katalog'];
$folder = $nazwisko . '/' . $katalog;

$target_file = $folder . "/". basename($_FILES["fileToUpload"]["name"]);
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file))
 { echo htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " uploaded."; }
 else { echo "Error uploading file."; }

 header("Location: dysk.php");
 die;
?>
