<?php
SESSION_START();

$base = 'http://localhost/devsbookoo';

$db_name = 'devsbookoo';
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';

// Dimensões maximas para as fotos
$maxWidth = 800;
$maxHeight = 800;

$pdo = new PDO("mysql:dbname={$db_name};host={$db_host}", $db_user, $db_pass);