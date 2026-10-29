<?php

class Discipline{
    private int $id;
    private string $libelle;
    private string $description;

    public function __construct(int $id,string $libelle ,string $description){

        $this->id=$id;
        $this->libelle=$libelle;
        $this->description=$description;
    }

    public function getId(){
        return $this->id;
    }
     public function getLibelle(){
        return $this->libelle;
    }
     public function getDescription(){
        return $this->description;
    }
   
}