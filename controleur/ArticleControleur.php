<?php

// CRUD
namespace controleur;

use PDOperso;
use Conf;
use modele\ArticleModele;
use modele\CategorieArticleModele;
use modele\CategorieModele;

class ArticleControleur extends BaseControleur
{
    public function liste()
    {
       $listeArticle = ArticleModele::findAllJoinUtilisateur();

       $parametres = compact('listeArticle');
       //envoyer dans Basecontroleur en tant que function

        //  $this->afficherVue($listeArticle);
        $this->afficherVue($parametres);
    }

    public function afficher($id)
    {
        $article = ArticleModele::findAllJoinUtilisateur();

        if ($article) {

            echo CategorieArticleModele::getNomTable();
            die();

            // On recupère toutes les categories de cet article
            $listeCategorie = CategorieArticleModele::findByIdArticleJoinCategorie($id);

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

                $listeCategorie = CategorieModele::findAll();

                //Si l'utilisateur a validé le formulaire
                if (isset($_POST['valider'])) {

                    $doublon = ArticleModele::findByTitre($_POST['titre']);

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

                        $idArticle = ArticleModele::createArticle(
                            $_POST['titre'],
                            $_POST['contenu'],
                            $nouveauNom,
                            $_SESSION['id']
                        );

                        foreach ($_POST['categorie'] as $idCategorie) {
                            
                            CategorieArticleModele::create($idArticle, $idCategorie);
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
        //si l'utilisateur est connecté
        if (isset($_SESSION["id"])) {

            $article = ArticleModele::findById($parametre);
            
            //si il est administrateur ou il es l'auteur de l'article
            if ($_SESSION['droit'] == 'admin' || $_SESSION['id'] == $article["id_utilisateur"]) {

                ArticleModele::deleteById($parametre);

                header('Location: ' . \Conf::URL . 'article/liste');
            } else {
                header('Location: ' . \Conf::URL);
            }
        }else{
            header('Location: ' . \Conf::URL);
        }
    }

    public function edition($id)
    {
        //si l'utilisateur est connecté
        if (isset($_SESSION["id"])) {

            $connexion = new PDOperso();

            //on recupere l'article a modifier
            $article = ArticleModele::findById($id);

            //on recupere les categories de l'article
            $listeCategorieArticle = CategorieArticleModele::findByIdArticle($id);

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
                    
                    $doublon = ArticleModele::findDoublon($_POST['titre'],$id);

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

                            ArticleModele::updateArticle(
                                $id, 
                                $_POST["titre"],
                                $_POST["contenu"],
                                $nouveauNom
                             );

                            header('Location: ' . Conf::URL . 'article/afficher/' . $id);
                        } else if (isset($_POST['suppression_image'])) {

                            ArticleModele::updateArticle(
                                $id, 
                                $_POST["titre"],
                                $_POST["contenu"]
                             );

                            header('Location: ' . Conf::URL . 'article/edition/' . $id);
                        }
                    } else {
                        $erreurDoublon = true;
                    }

                    //on efface toutes les categories de cet article
                    CategorieArticleModele::deleteByIdArticle($id);

                    //enregistrer les categories
                    foreach ($_POST['categorie'] as $idCategorie) {
                        CategorieArticleModele::create($id, $idCategorie);
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
        $listeArticle = ArticleModele::recherche($mot);

        $estUneRecherche = true;

        $parametres = compact('listeArticle', 'estUneRecherche');

        $this->afficherVue($parametres);
    }
}
