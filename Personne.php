<?php

class Personne 
{
    protected $nom;
    protected $prenom;

    public function __construct($nom, $prenom)
    {
        $this->setNom=$nom;
        $this->prenom=$prenom;
    }
    
    // function nomComplet() 
    // {
    //     echo "Je m'appele " . $this->prenom . " " . $this->nom;
    // }
    /**
     * Get the value of nom
     */ 
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set the value of nom
     *
     * @return  self
     */ 
    public function setNom($nom)
    {
        $this->nom = strtoupper($nom);

        return $this;
    }

    /**
     * Get the value of prenom
     */ 
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set the value of prenom
     *
     * @return  self
     */ 
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }
    }
