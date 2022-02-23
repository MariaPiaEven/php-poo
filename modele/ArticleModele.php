<?php

namespace modele;

use PDOperso;

class ArticleModele extends BaseModele {

    public static function updateArticle($id, $titre, $contenu, $nouveauNomImage = ""){

        $connexion = new PDOperso();

        if ($nouveauNomImage == null) {

            $requete = $connexion->prepare(
                'UPDATE article SET titre = :titre, contenu = :contenu WHERE id = :id'
            );

            $requete->execute([
                ':titre' => $titre,
                ':contenu' => $contenu, 
                ':id' => $id
            ]);

        } else {
            $requete = $connexion->prepare(
                    'UPDATE article 
                    SET titre = :titre, 
                    contenu = :contenu,
                    nom_image = :nom_image
                    WHERE id = :id'
            );

            $requete->execute([
                ':titre' => $titre,
                ':contenu' => $contenu,
                ':nom_image' => $nouveauNomImage == "" ? null : $nouveauNomImage,
                ':id' => $id
            ]);
        }
    }

    public static function findDoublon($titre, $idAexclure){

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT * 
            FROM article 
            WHERE titre = ?
            AND id != ?"
        );

        $requete->execute([$titre, $idAexclure]);
        return $requete->fetch();
    }
    
    public static function createArticle($titre, $contenu, $nouveauNomimage, $idauteur){

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "INSERT INTO article (titre,contenu,nom_image,id_utilisateur)
            VALUES (?,?,?,?)"
        );

        $requete->execute([
            $titre, 
            $contenu, 
            $nouveauNomimage, 
            $idauteur
        ]);

        return $connexion->lastInsertId();
    }

    public static function findByTitre($titre){

        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT *
             FROM article
             WHERE titre = ?");

        $requete->execute([$titre]);
        return $requete->fetch();
    }

    public static function findAllJoinUtilisateur(){
        $connexion = new PDOperso();
        //etoile ce pour recuperer tous les colonnes de la bdd
        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication, nom_image, pseudo, id_utilisateur
            FROM article
            LEFT JOIN utilisateur ON utilisateur.id = article.id_utilisateur"
        );
        $requete->execute();
        return $requete->fetchAll(); //fetch ce pour lire les resultats de PDO (php data objet) pour acceder a la base de donnes

    }

    public static function findByIdJoinUtilisateur($id)
    {
        include("bdd.php");

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication,nom_image, pseudo
             FROM article
             JOIN utilisateur ON utilisateur.id = article.id_utilisateur
             WHERE article.id = ?"
        );
        //  echo "<h1>Affichage d'un article $id</h1>";

        $requete->execute([$id]);

        return $requete->fetch();
    }
}

?>