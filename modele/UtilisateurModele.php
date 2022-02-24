<?php

namespace modele;

use PDO;
use PDOperso;

class UtilisateurModele extends BaseModele
{

    public static function findAllJoinDroit()
    {

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT utilisateur.id as id, pseudo, denomination
     FROM utilisateur
     LEFT JOIN droit ON utilisateur.id_droit = droit.id
     "
        );
        $requete->execute();
        return $requete->fetchAll();
    }

    public static function findByPseudoJoinDroit($pseudo)
    {
        $connexion = new PDOperso();

            $requete = $connexion->prepare(
                "SELECT utilisateur.id , pseudo , mot_de_passe , denomination
                FROM utilisateur 
                LEFT JOIN droit ON droit.id = utilisateur.id_droit
                WHERE pseudo = ?"
            );

            $requete->execute([
                $pseudo
            ]);
            // on récupére l'utilisateur ayant le pseudo saisi
            return $requete->fetch();
    }

    public static function create($pseudo, $mot_de_passe){
         $connexion = new PDOperso();
                $requete = $connexion->prepare(
                    'INSERT INTO utilisateur (pseudo, mot_de_passe) VALUES (?,?)'
                );

                $requete->execute([
                    $pseudo,
                    $mot_de_passe
                ]);
    }

    public static function update($idUtilisateur, $idDroit, $pseudo){

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "UPDATE utilisateur
            SET pseudo = ? , id_droit = ?
            WHERE id = ?"
        );

        $requete->execute([
            $idUtilisateur, 
            $idDroit, 
            $pseudo
        ]);
    }
}
