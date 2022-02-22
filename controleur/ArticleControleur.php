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
        include('bdd.php');
        $erreurDoublon = false;

        if (isset($_SESSION['droit'])) {

            if ($_SESSION['droit'] == "admin" || $_SESSION['droit'] == "redacteur") {

                $requete = $connexion->prepare(
                    "SELECT * 
                    FROM categorie"
                );

                $requete->execute();
                $listeCategorie = $requete->fetchAll();

                //Si l'utilisateur a validé le formulaire
                if (isset($_POST['valider'])) {

                    $requete = $connexion->prepare("SELECT * FROM article WHERE titre = ?");
                    $requete->execute([$_POST['titre']]);
                    $doublon = $requete->fetch();

                    if (!$doublon) {

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

                        $idArticle = $connexion->lastInsertId();

                        foreach ($_POST['categorie'] as $idCategorie) {
                            $requete = $connexion->prepare(
                                "INSERT INTO categorie_article (id_article,id_categorie) VALUES (?,?)"
                            );

                            $requete->execute([$idArticle, $idCategorie]);
                        }

                        header('Location: ' . \Conf::URL . 'article/liste');
                    } else {
                        $erreurDoublon = true;
                    }
                }

                $parametres = compact('erreurDoublon', 'listeCategorie');
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
        //si l'utilisateur est connecté
        if (isset($_SESSION["id"])) {

            $connexion = new PDOperso();

            //on recupere l'article a modifier
            $requete = $connexion->prepare('SELECT * FROM article WHERE id = ?');
            $requete->execute([$id]);
            $article = $requete->fetch();

            //on recupere les categories de l'article
            $requete = $connexion->prepare(
                "SELECT * 
                FROM categorie_article
                WHERE id_article = ?"
            );
            $requete->execute([$id]);
            $listeCategorieArticle = $requete->fetchAll();

            $listeIdCategorieArticle = [];

            foreach ($listeCategorieArticle as $categorieArticle) {
                array_push($listeIdCategorieArticle, $categorieArticle['id_categorie']);
            }


            //on recupere la liste des categories
            $requete = $connexion->prepare("SELECT * FROM categorie");
            $requete->execute();
            $listeCategorie = $requete->fetchAll();


            //si l'utilisateur est administrateur ou auteur de l'article
            if ($_SESSION['droit'] == 'admin' || $_SESSION['id'] == $article["id_utilisateur"]) {

                $erreurDoublon = false;

                //si il validé le formulaire ou si il supprime l'image
                if (isset($_POST['valider']) || isset($_POST['suppression_image'])) {
                    $requete = $connexion->prepare(
                        "SELECT * 
                        FROM article 
                        WHERE titre = ?
                        AND id != ?"
                    );

                    $requete->execute([$_POST['titre'], $id]);
                    $doublon = $requete->fetch();

                    //si le titre n'existe pas dejà
                    if (!$doublon) {

                        if (isset($_POST['valider'])) {

                            $nouveauNom = null;

                            if ($_FILES['image']['tmp_name'] != "") {
                                // name input  //par default
                                $nomTemporaire = $_FILES['image']['tmp_name'];

                                $nouveauNom = "image_" . str_replace(' ', '_', $_POST['titre']) . "_" . time() . ".jpg";

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
                    } else {
                        $erreurDoublon = true;
                    }

                    //on efface toutes les categories de cet article
                    $requete = $connexion->prepare(
                        "DELETE
                        FROM categorie_article
                        WHERE id_article = ?"
                    );

                    $requete->execute([$id]);

                    //enregistrer les categories
                    foreach ($_POST['categorie'] as $idCategorie) {
                        $requete = $connexion->prepare(
                            "INSERT INTO categorie_article (id_article,id_categorie) VALUES (?,?)"
                        );

                        $requete->execute([$id, $idCategorie]);
                    }
                }

                $parametres = compact(
                    'article',
                    'erreurDoublon',
                    'listeCategorie',
                    'listeIdCategorieArticle'
                );

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
