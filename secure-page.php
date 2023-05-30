<?php session_start();

if(!isset($_SESSION['auth'])) {
    header('location:index.php');
}
?>

<h1>Congratulations! You have access to this page.</h1>