<?php

class Discipline
{
    private $id;
    private $libelle;
    private $description;

    public function __construct($id, $libelle, $description)
    {
        $this->id = $id;
        $this->libelle = $libelle;
        $this->description = $description;
    }

    public function getId()
    {
        return $this->id;
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