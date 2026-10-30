<?php 

require_once __DIR__ . '/../../backend/classes/GestionDiscipline.php';

header('Content-Type:application/json');

class DisciplineController{

public function listerDisciplines(){
    $gestion=new GestionDiscipline();
    

    $disciplines=$gestion->getAll();
    $data=[];

    foreach($disciplines as $d){
        $data[]=[
                'id'=>$d->getId(),
                 'libelle'=>$d->getLibelle(),
                  'description'=>$d->getDescription()

            ];

    }
    

    echo json_encode($data);
}

public function ajouterDiscipline(){
    
    $gestion=new GestionDiscipline();
    $libelle=$_POST['libelle']?? "";
    $description=$_POST['description'] ?? "";

    $nouvelle=$gestion->create($libelle,$description);

   echo  json_encode(['success'=>true,'id'=>$nouvelle->getId()]);

}

}


$methode=$_SERVER['REQUEST_METHOD'];
$controller=new DisciplineController();

if($methode==='GET'){
    $controller->listerDisciplines();
}else{
    $controller->ajouterDiscipline();
}