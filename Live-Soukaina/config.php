<?php
$host = 'localhost';
$db   = 'recettes_db';
$user = 'root';
$pass = 'Mysql@123';
$charset = 'utf8mb4';

$pdo=New PDO( "mysql:host=$host;dbname=$db;charset=$charset;port=3307",$user,$pass);

try {

   
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
} catch (PDOException $e) {
    echo "Error : " . $e->getMessage();
}
?>
