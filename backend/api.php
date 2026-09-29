<?php

header('Content-Type: application/json');

require_once 'Discipline.php';

$fichier = __DIR__ . '/../data/disciplines.json';

$disciplines = file_exists($fichier)
    ? json_decode(file_get_contents($fichier), true)
    : [];

$methode = $_SERVER['REQUEST_METHOD'];

$body = json_decode(file_get_contents('php://input'), true);


if ($methode === 'GET') {

    echo json_encode([
        'success' => true,
        'data' => $disciplines
    ]);


} elseif ($methode === 'POST') {

    $id = time();

    $discipline = new Discipline(
        $id,
        $body['libelle'],
        $body['description']
    );

    $nouvelleDiscipline = [
        'id_discipline' => $discipline->getIdDiscipline(),
        'libelle' => $discipline->getLibelle(),
        'description' => $discipline->getDescription()
    ];

    $disciplines[] = $nouvelleDiscipline;

    file_put_contents(
        $fichier,
        json_encode($disciplines, JSON_PRETTY_PRINT)
    );

    echo json_encode([
        'success' => true,
        'message' => 'Discipline ajoutée',
        'data' => $nouvelleDiscipline
    ]);


} else {

    echo json_encode([
        'success' => false,
        'message' => 'Méthode HTTP non autorisée'
    ]);
}