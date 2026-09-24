<?php

$host = "localhost";
$port = "3307";
$dbname = "recettes_db";
$username = "root";
$password = "Mysql@123";

try {

    $pdo = new PDO(
        "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

   



} catch (PDOException $e) {

    echo "Erreur de connexion : " . $e->getMessage();

}
?>