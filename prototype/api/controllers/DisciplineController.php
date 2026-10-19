<?php
// 🎯 Nettoie tout BOM ou sortie parasite AVANT le JSON
while (ob_get_level()) ob_end_clean();
ob_start();

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../backend/classes/GestionDiscipline.php';

$gestion = new GestionDiscipline();
$methode = $_SERVER['REQUEST_METHOD'];

if ($methode === 'GET') {
    $disciplines = $gestion->getAll();
    $data = [];
    foreach ($disciplines as $d) {
        $data[] = [
            'id'          => $d->getId(),
            'libelle'     => $d->getLibelle(),
            'description' => $d->getDescription()
        ];
    }
    echo json_encode($data);
}
elseif ($methode === 'POST') {
    $libelle     = trim($_POST['libelle']     ?? '');
    $description = trim($_POST['description'] ?? '');

    if ($libelle && $description) {
        $nouvelle = $gestion->create($libelle, $description);
        echo json_encode(['success' => true, 'id' => $nouvelle->getId()]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Champs obligatoires']);
    }
}