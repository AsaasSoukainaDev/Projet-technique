<?php
require_once __DIR__ . '/Discipline.php';

class GestionDiscipline {
    private static string $dataFile = __DIR__ . '/../../data/disciplines.json';

    // Lire toutes les disciplines
    public function getAll(): array {
        if (!file_exists(self::$dataFile)) return [];

        $data = json_decode(file_get_contents(self::$dataFile), true) ?? [];

        return array_map(fn($row) => new Discipline(
            $row['id'],
            $row['libelle'],
            $row['description']
        ), $data);
    }

    // Ajouter une discipline
    public function create(string $libelle, string $description): Discipline {
        $disciplines = $this->getAll();

        $nouvelle = new Discipline(count($disciplines) + 1, $libelle, $description);

        $disciplines[] = $nouvelle;
        $this->saveAll($disciplines);

        return $nouvelle;
    }

    // Sauvegarder dans le JSON
    private function saveAll(array $disciplines): void {
        $data = array_map(fn($d) => [
            'id'          => $d->getId(),
            'libelle'     => $d->getLibelle(),
            'description' => $d->getDescription()
        ], $disciplines);

        file_put_contents(
            self::$dataFile,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );
    }
}