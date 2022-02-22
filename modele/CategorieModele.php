<?php

namespace modele;

use PDOperso;

class CategorieModele{

    //Eviter pour ecrire la requete chaque fois
    public static function findAll(){

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "SELECT *
             FROM categorie"
        );
        
        $requete->execute();

        return $requete->fetchAll(); 
    }

}

?>