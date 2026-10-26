<?php
require_once __DIR__ . '/../../backend/classes/GestionDiscipline.php';

class DisciplineController {

    public function listerDisciplines(): void {
        $gestion = new GestionDiscipline();
        $disciplines = $gestion->getAll();

        $data = [];
        foreach ($disciplines as $d) {
            $data[] = [
                'id'          => $d->getId(),
                'libelle'     => $d->getLibelle(),
                'description' => $d->getDescription()
            ];
        }

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode($data);
    }

    public function ajouterDiscipline(): void {
        $gestion = new GestionDiscipline();

        $libelle     = $_POST['libelle']     ?? '';
        $description = $_POST['description'] ?? '';

        $nouvelle = $gestion->create($libelle, $description);

        header('Content-Type: application/json');
        header('Access-Control-Allow-Origin: *');
        echo json_encode([
            'success' => true,
            'id'      => $nouvelle->getId()
        ]);
    }
}

// --- ROUTAGE ---
$methode = $_SERVER['REQUEST_METHOD'];
$controller = new DisciplineController();

if ($methode === 'GET') {
    $controller->listerDisciplines();
} elseif ($methode === 'POST') {
    $controller->ajouterDiscipline();
}