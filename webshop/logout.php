<?php
session_start();
unset($_SESSION['customer']);
header('HTTP/1.1 303 See Other');
header('Location: index.php');
?>
