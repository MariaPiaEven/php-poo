<?php

// CRUD
namespace controleur;

use PDOperso;
use Conf;

class ArticleControleur extends BaseControleur
{
     public function liste()
     {
         $connexion = new \PDOperso();

         //etoile ce pour recuperer tous les colonnes de la bdd
         $requete = $connexion->prepare("SELECT * FROM article");
         $requete ->execute();
         $listeArticle = $requete->fetchAll(); //fetch ce pour lire les resultats de PDO (php data objet) pour acceder a la base de donnes

         $parametres = compact('listeArticle');

        //  $this->afficherVue($listeArticle);
         $this->afficherVue($parametres);
         
        
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
            // include('vue/afficher.php');
            $parametres = compact('article');
            $this->afficherVue($parametres);
            
        }else{
            header('Location: '.\Conf::URL.'page/pageNonTrouve');
        }
        
        }

     public function insertion()
     {
         //Si l'utilisateur a validé le formulaire
        if(isset($_POST['valider'])){

            $nouveauNom = NULL;
         
            //Si l'utilisateur a selectionné une image
            if($_FILES['image']['tmp_name'] !=""){
                                    // name input  //par default
                $nomTemporaire = $_FILES['image']['tmp_name'];
                
                //on créait (on crée) un nom unique a partir du titre de l'article
                $nouveauNom = "image_". str_replace(' ','_',$_POST['titre']).".jpg";

                move_uploaded_file($nomTemporaire, "./assets/images/" .$nouveauNom);
            }

                include('bdd.php');

                $requete = $connexion->prepare(
                    "INSERT INTO article (titre,contenu,nom_image)
                     VALUES (?,?,?)");
            
                $requete->execute([
                    $_POST['titre'],
                    $_POST['contenu'],
                    $nouveauNom
                ]);

                header('Location: '.\Conf::URL.'/article/liste');
            }
        
        // include('vue/insertion.php');
        $this->afficherVue([], 'insertion');
     }

     public function supprimer($id)
    {
 
        include 'bdd.php';
 
        $supprimer = $connexion->prepare('DELETE FROM article WHERE id = ?');
 
        $supprimer->execute([$id]);
 
        header('Location: ' . \Conf::URL.'article/liste');
    }

     public function edition()
     {

        include('bdd.php');

        $requete = $connexion->prepare(
            'SELECT * FROM article WHERE id = ?'
        );

        $requete->execute([
            $parametre
        ]);

        $article = $requete->fetch();

        if (isset($_POST['valider'])) {

            $requete = $connexion->prepare(
                'UPDATE article
            SET titre = ?, contenu = ?
            WHERE id = ?'
            );
            $requete->execute([
                $_POST['titre'],
                $_POST['contenu'],
                $parametre
            ]);
            header('location: ' . Conf::URL . 'article/liste');
        }

        $parametres = compact('article');

        $this->afficherVue($parametres, 'edition');     

        }
     
}