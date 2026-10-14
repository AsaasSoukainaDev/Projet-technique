<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once __DIR__ . '/../../backend/classes/GestionDiscipline.php';

$gestion = new GestionDiscipline();
$methode = $_SERVER['REQUEST_METHOD'];

// GET : afficher toutes les disciplines
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

// POST : ajouter une discipline
elseif ($methode === 'POST') {
    $libelle     = $_POST['libelle']     ?? null;
    $description = $_POST['description'] ?? null;

    if ($libelle && $description) {
        $nouvelle = $gestion->create($libelle, $description);
        echo json_encode([
            'success' => true,
            'id'      => $nouvelle->getId()
        ]);
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Champs obligatoires manquants']);
    }
}