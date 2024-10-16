<?php
$host = '127.0.0.1';
$db = 'inventory';
$user = 'root';
$pass = '';
// $dsn = "mysql:host=$host;dbname=$db";
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error connecting to the database: " . $e->getMessage());
}

$db2 = 'framecode';

try{
    $pdo2 = new PDO("mysql:host=$host;dbname=$db2", $user , $pass);
    $pdo2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e){
    die("Error connecting to the databse" . $e->getMessage());
}

?>