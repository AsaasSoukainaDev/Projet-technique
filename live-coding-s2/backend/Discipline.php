<?php

class Discipline
{
    private $id_discipline;
    private $libelle;
    private $description;

    public function __construct($id_discipline, $libelle, $description)
    {
        $this->id_discipline = $id_discipline;
        $this->libelle = $libelle;
        $this->description = $description;
    }

    public function getIdDiscipline()
    {
        return $this->id_discipline;
    }

   

    public function getLibelle()
    {
        return $this->libelle;
    }

  

    public function getDescription()
    {
        return $this->description;
    }

  
}