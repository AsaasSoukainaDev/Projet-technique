<?php


require_once __DIR__ . '/../backend/services/DisciplineService.php';

header("Content-Type: application/json");

$methode = $_SERVER["REQUEST_METHOD"];
$service = new DisciplineService();

if ($methode === "GET") {
    echo json_encode($service->listerDisciplines());
}

if ($methode === "POST") {
    echo json_encode($service->ajouterDiscipline());
}

require_once __DIR__ . '/../backend/services/DisciplineService.php';