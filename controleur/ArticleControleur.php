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
        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication, nom_image, pseudo, id_utilisateur
            FROM article
            LEFT JOIN utilisateur ON utilisateur.id = article.id_utilisateur"
        );

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
            "SELECT article.id as id, titre, contenu, date_publication,nom_image, pseudo
             FROM article
             JOIN utilisateur ON utilisateur.id = article.id_utilisateur
             WHERE article.id = ?"
        );
        //  echo "<h1>Affichage d'un article $id</h1>";

        $requete->execute([$id]);

        $article = $requete->fetch();

        if ($article) {

            // On recupère toutes les categories de cet article
            $requete = $connexion->prepare(
                "SELECT * 
                FROM categorie_article 
                JOIN categorie ON categorie.id = categorie_article.id_categorie
                WHERE id_article = ?
            "
            );

            $requete->execute([$id]);

            $listeCategorie = $requete->fetchAll();

            // include('vue/afficher.php');
            $parametres = compact('article', 'listeCategorie');

            $this->afficherVue($parametres, "afficher");
        } else {
            header('Location: ' . \Conf::URL . 'page/pageNonTrouve');
        }
    }

    public function insertion()
    {

        $erreurDoublon = false;

        if(isset($_SESSION['droit'])) {

            if($_SESSION['droit']== "admin" || $_SESSION['droit'] == "redacteur"){

        //Si l'utilisateur a validé le formulaire
        if (isset($_POST['valider'])) {

            include('bdd.php');

            $requete = $connexion->prepare("SELECT * FROM article WHERE titre = ?");
            $requete->execute([$_POST['titre']]);
            $doublon = $requete->fetch();

            if(!$doublon){

            $nouveauNom = NULL;

            //Si l'utilisateur a selectionné une image
            if ($_FILES['image']['tmp_name'] != "") {
                // name input  //par default
                $nomTemporaire = $_FILES['image']['tmp_name'];

                //on créait (on crée) un nom unique a partir du titre de l'article
                $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
            }

            $requete = $connexion->prepare(
                "INSERT INTO article (titre,contenu,nom_image,id_utilisateur)
                VALUES (?,?,?,?)"
            );

            $requete->execute([
                $_POST['titre'],
                $_POST['contenu'],
                $nouveauNom,
                $_SESSION['id']
            ]);

            header('Location: ' . \Conf::URL . 'article/liste');

            }else{
                $erreurDoublon = true;
            }
        }

        $parametres = compact('erreurDoublon');
        // include('vue/insertion.php');
        $this->afficherVue($parametres, 'insertion');
            }
        }
    }

    public function supprimer($parametre)
    {
        if (isset($_SESSION["id"])) {

            $connexion = new PDOperso();

            $requete = $connexion->prepare("SELECT * FROM article WHERE id= ?");

            $requete->execute([$parametre]);

            $article = $requete->fetch();

            if ($_SESSION['droit'] == 'admin' || $_SESSION['id'] == $article["id_utilisateur"]) {

                include 'bdd.php';

                $supprimer = $connexion->prepare('DELETE FROM article WHERE id = ?');

                $supprimer->execute([$parametre]);

                header('Location: ' . \Conf::URL . 'article/liste');
            } else {
                header('Location: ' . \Conf::URL);
            }
        }
    }

    public function edition($id)
    {

        if (isset($_SESSION["id"])) {

            $connexion = new PDOperso();
            $requete = $connexion->prepare('SELECT * FROM article WHERE id = ?');
            $requete->execute([$id]);

            $article = $requete->fetch();

            if ($_SESSION['droit'] == 'admin' || $_SESSION['id'] == $article["id_utilisateur"]) {

                if (isset($_POST['valider'])) {

                    $nouveauNom = null;

                    if ($_FILES['image']['tmp_name'] != "") {
                        // name input  //par default
                        $nomTemporaire = $_FILES['image']['tmp_name'];

                        $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . ".jpg";

                        move_uploaded_file($nomTemporaire, "./assets/images/" . $nouveauNom);
                    }

                    if ($nouveauNom == null) {
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
                    } else {
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

                $parametres = compact('article');

                $this->afficherVue($parametres, 'edition');
            } else {
                header('Location: ' . Conf::URL);
            }
        } else {
            header('Location: ' . Conf::URL);
        }
    }

    public function recherche($mot)
    {
        $connexion = new PDOperso();

        $requete = $connexion->prepare(
            "SELECT article.id as id, titre, contenu, date_publication,nom_image, pseudo, admin
            FROM article 
            JOIN utilisateur ON utilisateur.id = article.id_utilisateur
            WHERE titre LIKE :recherche 
            OR contenu LIKE :recherche
            OR pseudo LIKe :recherche
            "
        );

        $requete->execute([':recherche' => '%' . $mot . '%']);

        $listeArticle = $requete->fetchAll();

        $parametres = compact('listeArticle');

        $this->afficherVue($parametres);
    }
}
