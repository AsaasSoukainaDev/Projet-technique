<?php
require_once __DIR__ . '/../dao/DisciplineDAO.php';
require_once __DIR__ . '/BaseService.php';

class DisciplineService extends BaseService {
    private DisciplineDAO $dao;

    public function __construct() {
        $this->dao = new DisciplineDAO();
    }

    public function listerDisciplines(): array {
        $disciplines = $this->dao->getAll();
        $data = [];

        foreach($disciplines as $d){
            $data[] = [
                'id'          => $d->getId(),
                'libelle'     => $d->getLibelle(),
                'description' => $d->getDescription()
            ];
        }
        return $data;
    }

    public function ajouterDiscipline(): array {
        $input = json_decode(file_get_contents("php://input"), true);
        
        $libelle = $input['libelle'] ?? "";
        $description = $input['description'] ?? "";

        try {
           
            $nouvelle = $this->dao->create($libelle, $description);

         

            
            return [
                "success" => true, 
                "id" => $nouvelle->getId()
            ];
            
        } catch (Exception $e) {
            return [
                "success" => false, 
                "message" => $e->getMessage()
            ];
        }
    }
}