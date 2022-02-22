<?php

namespace modele;

use PDOperso;

class UtilisateurModele {

    public static function deleteById($id){

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "DELETE 
            FROM utilisateur 
            WHERE id = ?");
    return $requete->execute([$id]);
    }
}