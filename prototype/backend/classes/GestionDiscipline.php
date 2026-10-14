<?php
require_once __DIR__ . '/Discipline.php';

class GestionDiscipline {
    private static string $dataFile = __DIR__ . '/../../data/disciplines.json';

    // Lire toutes les disciplines
    public function getAll(): array {
        if (!file_exists(self::$dataFile)) return [];

        $json = file_get_contents(self::$dataFile);
        $data = json_decode($json, true) ?? [];

        $disciplines = [];
        foreach ($data as $row) {
            $disciplines[] = new Discipline(
                $row['id'],
                $row['libelle'],
                $row['description']
            );
        }
        return $disciplines;
    }

    // Ajouter une discipline
    public function create(string $libelle, string $description): Discipline {
        $disciplines = $this->getAll();

        $nouvelId = count($disciplines) + 1;

        $nouvelle = new Discipline($nouvelId, $libelle, $description);
        $this->saveAll($disciplines, $nouvelle);
        return $nouvelle;
    }

    // Sauvegarder dans le JSON
    private function saveAll(array $disciplines, ?Discipline $nouvelle = null): void {
        $data = [];

        foreach ($disciplines as $d) {
            $data[] = [
                'id'          => $d->getId(),
                'libelle'     => $d->getLibelle(),
                'description' => $d->getDescription()
            ];
        }

        if ($nouvelle !== null) {
            $data[] = [
                'id'          => $nouvelle->getId(),
                'libelle'     => $nouvelle->getLibelle(),
                'description' => $nouvelle->getDescription()
            ];
        }

      

        file_put_contents(
            self::$dataFile,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}