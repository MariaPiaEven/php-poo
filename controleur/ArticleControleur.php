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
        $requete->execute();
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
             WHERE id = ?"
        );
        //  echo "<h1>Affichage d'un article $id</h1>";

        $requete->execute([$id]);

        $article = $requete->fetch();

        if ($article) {
            // include('vue/afficher.php');
            $parametres = compact('article');
            $this->afficherVue($parametres, "afficher");
        } else {
            header('Location: ' . \Conf::URL . 'page/pageNonTrouve');
        }
    }

    public function insertion()
    {
        //Si l'utilisateur a validé le formulaire
        if (isset($_POST['valider'])) {

            $nouveauNom = NULL;

            //Si l'utilisateur a selectionné une image
            if ($_FILES['image']['tmp_name'] != "") {
                // name input  //par default
                $nomTemporaire = $_FILES['image']['tmp_name'];

                //on créait (on crée) un nom unique a partir du titre de l'article
                $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
            }

            include('bdd.php');

            $requete = $connexion->prepare(
                "INSERT INTO article (titre,contenu,nom_image)
                     VALUES (?,?,?)"
            );

            $requete->execute([
                $_POST['titre'],
                $_POST['contenu'],
                $nouveauNom
            ]);

            header('Location: ' . \Conf::URL . '/article/liste');
        }

        // include('vue/insertion.php');
        $this->afficherVue([], 'insertion');
    }

    public function supprimer($id)
    {

        include 'bdd.php';

        $supprimer = $connexion->prepare('DELETE FROM article WHERE id = ?');

        $supprimer->execute([$id]);

        header('Location: ' . \Conf::URL . 'article/liste');
    }

    public function edition($id)
    {

        $connexion = new PDOperso();

        if (isset($_POST['valider'])) {

            $nouveauNom = null;


            if ($_FILES['image']['tmp_name'] != "") {
                // name input  //par default
                $nomTemporaire = $_FILES['image']['tmp_name'];


                $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
            }

            if($nouveauNom == null){
                $requete = $connexion->prepare(
                    'UPDATE article 
                    SET titre = :titre, 
                    contenu = :contenu
                    WHERE id = :id'
                );

                $requete->execute([
                        ':titre' => $_POST['titre'],
                        ':contenu' => $_POST['contenu'],
                        ':id' => $id
                    ]);
            }   else {
                $requete = $connexion->prepare(
                    'UPDATE article 
                    SET titre = :titre, 
                    contenu = :contenu,
                    nom_image = :nom_image
                    WHERE id = :id'
                );

                $requete->execute([
                        ':titre' => $_POST['titre'],
                        ':contenu' => $_POST['contenu'],
                        ':nom_image' => $nouveauNom,
                        ':id' => $id
                    ]);
            }

            header('Location: ' . Conf::URL . 'article/afficher/' . $id);
        } else if (isset($_POST['suppression_image'])) {

            $connexion = new PDOperso();

            $requete = $connexion->prepare(
                'UPDATE article SET titre = :titre, contenu = :contenu, nom_image = NULL WHERE id = :id'
            );

            $requete->execute([
                    ':titre' => $_POST['titre'],
                    ':contenu' => $_POST['contenu'],
                    ':id' => $id
                ]);

            header('Location: ' . Conf::URL . 'article/edition/' . $id);
        }

        $requete = $connexion->prepare('SELECT * FROM article WHERE id = ?');
        $requete->execute([$id]);

        $article = $requete->fetch();
        $parametres = compact('article');

        $this->afficherVue($parametres, 'edition');
    }

    public function recherche()
    {
        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT * FROM article WHERE (titre LIKE :recherche OR contenu LIKE :recherche)"
        );

        $requete->execute([':recherche' => '%' .$_POST['recherche'].'%']);

        $listeArticle = $requete->fetchAll();

        $parametres = compact('listeArticle');

        $this->afficherVue($parametres, 'liste');
    }
}
