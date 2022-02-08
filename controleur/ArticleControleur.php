<?php

// CRUD
namespace controleur;

class ArticleControleur 
{
     public function liste()
     {
         include("bdd.php");

         //etoile ce pour recuperer tous les colonnes de la bdd
         $requete = $connexion->prepare("SELECT * FROM article");
         $requete ->execute();
         $listeArticle = $requete->fetchAll(); //fetch ce pour lire les resultats de PDO (php data objet) pour acceder a la base de donnes

         include('vue/liste.php');
     }  

     public function afficher($id)
     {
         include("bdd.php");

         $requete = $connexion->prepare(
             "SELECT *
             FROM article
             WHERE id = ?");
            //  echo "<h1>Affichage d'un article $id</h1>";
            
        $requete->execute([$id]);

        $article=$requete->fetch();

        if($article){
            include('vue/afficher.php');
        }else{
            header('Location: '.\Conf::URL.'page/pageNonTrouve');
        }
        
        }

     public function insertion()
     {
         //Si l'utilisateur a validé le formulaire
        if(isset($_POST['valider'])){

            include('bdd.php');

            $requete = $connexion->prepare("INSERT INTO article (titre,contenu) VALUES (?,?)");
        
            $requete->execute([
                $_POST['titre'],
                $_POST['contenu']
            ]);

            header('Location: '.\Conf::URL.'/article/liste');
        }
        
        include('vue/insertion.php');
     }

     public function supprimer($id)
    {
 
        include 'bdd.php';
 
        $supprimer = $connexion->prepare('DELETE FROM article WHERE id = ?');
 
        $supprimer->execute([$id]);
 
        header('Location: ' . \Conf::URL.'Article/liste');
    }

     public function edition()
     {
         echo "<h1>Edition d'un article</h1>";
     }
     
}