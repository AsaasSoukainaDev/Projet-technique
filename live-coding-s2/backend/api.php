
<?php

header("Content-Type: application/json");

require_once "Discipline.php";

class GestionDiscipline
{
    private $path_file;

    public function __construct()
    {
        $this->path_file = __DIR__ . "/../data/disciplines.json";
    }



    public function getDisciplines()
    {
        $contenu = file_get_contents($this->path_file);

        $disciplines = json_decode($contenu, true);

        echo json_encode($disciplines);
    }


    
    public function ajouterDiscipline()
    {
        $contenu = file_get_contents($this->path_file);

        $disciplines = json_decode($contenu, true);

        $data = json_decode(
            file_get_contents("php://input"),
            true
        );


        $discipline = new Discipline(
            count($disciplines) + 1,
            $data["libelle"],
            $data["description"]
        );


        $disciplines[] = [
            "id_discipline" => $discipline->getIdDiscipline(),
            "libelle" => $discipline->getLibelle(),
            "description" => $discipline->getDescription()
        ];


        file_put_contents(
            $this->path_file,
            json_encode($disciplines, JSON_PRETTY_PRINT)
        );


        echo json_encode($disciplines);
    }


   
    public function traiterRequete()
    {
        $method = $_SERVER["REQUEST_METHOD"];


        if ($method === "GET") {

            $this->getDisciplines();

        }


        if ($method === "POST") {

            $this->ajouterDiscipline();

        }
    }
}


$api = new GestionDiscipline();

$api->traiterRequete();

