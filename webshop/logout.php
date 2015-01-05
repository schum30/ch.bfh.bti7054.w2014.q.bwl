<?php
session_start();
unset($_SESSION['user']);
header('HTTP/1.1 303 See Other');
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
