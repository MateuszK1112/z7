<?php 
  $dbhost = 'mysql01.skyland3r112.beep.pl';
  $dbuser = 'skyland3r112_z7';
  $dbpassword = 'Oduska@1234$';
  $database = 'skyland3r112_z7';

  $connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $database);
  
  if (!$connection) {
    echo "Błąd połączenia z MySQL." . PHP_EOL;
    echo "Errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "Error: " . mysqli_connect_error() . PHP_EOL;
    exit;
  }

  mysqli_set_charset($connection, 'utf8');
?>
