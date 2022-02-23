<?php

namespace modele;

use PDOperso;

class BaseModele
{

    public static function deleteById($id){

            $connexion = new PDOperso();
            $requete = $connexion->prepare(
                "DELETE 
                FROM " . self::getNomTable() . "
                WHERE id = ?");

        return $requete->execute([$id]);
        
    }

    public static function findById($id){
        $connexion= new PDOperso();
        $requete= $connexion->prepare(
            "SELECT * FROM " . self::getNomTable() .
            " WHERE id = ?"
        );

        $requete->execute([$id]);

        return $requete->fetch();
    }

    public static function findAll()
    {

        $connexion = new PDOperso();
        $requete = $connexion->prepare(
            "SELECT *
             FROM " . self::getNomTable()
            );

        $requete->execute();

        return $requete->fetchAll();
    }

    public static function getNomTable()
    {
        $nomTable = get_called_class(); // \modele\ArticleModele
        $nomTable = substr($nomTable, 7, -6); //CategorieArticle
        $nomTable = lcfirst($nomTable); //CategorieArticle
        $nomTable = preg_replace( '/([A-Z])/' , '_$0' , $nomTable); //Categorie_Article
        $nomTable = strtolower($nomTable); //categorie_article

        return $nomTable;
        //lcfirst(substr(get_called_class(),7,-6));
    }

    
}

?>
