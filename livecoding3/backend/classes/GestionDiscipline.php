<?php

require_once __DIR__ . '/Discipline.php';

class GestionDiscipline{
    private static string $dataFile= __DIR__ . '/../../data/disciplines.json';

    public function getAll(){
        $data= json_decode(file_get_contents(self::$dataFile),true);

        $disciplines=[];

        foreach($data as $row){
            $disciplines[]= new Discipline(
                $row['id'],
                 $row['libelle'],
                  $row['description']

            );
        }

        return $disciplines;
    }


    public function create(string $libelle, string $description):Discipline{
        $disciplines=$this->getAll();
        $nouvelleid=count($disciplines)+1;

        $nouvelle=new Discipline($nouvelleid,$libelle,$description);
        $disciplines[]=$nouvelle;
        $this->saveAll($disciplines);
        return $nouvelle;
    }



    public function saveAll(array $disciplines){
        
        $data=[];

        foreach($disciplines as $d){
            $data[]=[
                'id'=>$d->getId(),
                 'libelle'=>$d->getLibelle(),
                  'description'=>$d->getDescription()

            ];
        }
        file_put_contents(self::$dataFile,json_encode($data,JSON_PRETTY_PRINT));
    }

    
    


}