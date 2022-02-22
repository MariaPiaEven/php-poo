<?php

namespace controleur;

use Conf;
use modele\UtilisateurModele;
use PDOperso;

class UtilisateurControleur extends BaseControleur
{

    public function liste()
    {

        //if(isset($_SESSION['droit'])&& in_array($_SESSION['droit'],["administrateur","redacteur"]))
        if (
            isset($_SESSION['droit'])
            && ($_SESSION['droit'] == "admin" || $_SESSION['droit'] == "redacteur")
        ) {

            $connexion = new \PDOperso();

            $requete = $connexion->prepare(
                "SELECT utilisateur.id as id, pseudo, denomination
             FROM utilisateur
             LEFT JOIN droit ON utilisateur.id_droit = droit.id
             "
            );
            $requete->execute();
            $listeUtilisateur = $requete->fetchAll();

            $parametres = compact('listeUtilisateur');

            // $this->afficherVue('listeUtilisateur');
            $this->afficherVue($parametres);
        } else {
            header("Location: " . Conf::URL);
        }
    }

    public function connexion()
    {

        $erreurPseudo = false;

        //si l'utilisateur valide la connexion
        if (isset($_POST['valider'])) {

            $connexion = new PDOperso();

            $requete = $connexion->prepare(
                "SELECT utilisateur.id , pseudo , mot_de_passe , denomination
                FROM utilisateur 
                LEFT JOIN droit ON droit.id = utilisateur.id_droit
                WHERE pseudo = ?"
            );

            $requete->execute([
                $_POST['pseudo']
            ]);
            // on récupére l'utilisateur ayant le pseudo saisi
            $utilisateur = $requete->fetch();

            //si l'utilisateur existe bien
            if ($utilisateur) {
                //si l'utilisateur a saisi un mot de passe compatible avec le mot passe crypte
                if (password_verify($_POST['mot_de_passe'], $utilisateur['mot_de_passe'])) {

                    $_SESSION['id'] = $utilisateur['id'];
                    $_SESSION['pseudo'] = $utilisateur['pseudo'];
                    $_SESSION['droit'] = $utilisateur['denomination'];

                    header("Location: " . Conf::URL);
                } else {
                    //si l'utilisateur a saisi un mauvais mot de passe
                    $erreurPseudo = true;
                }
            } else {
                //si l'utilisateur a saisi un mauvais Pseudo
                $erreurPseudo = true;
            }
        }

        $parametres = compact('erreurPseudo');

        $this->afficherVue($parametres, 'connexion');
    }

    public function inscription()
    {

        $erreurLongueurPseudo = false;
        $erreurMotdePasseIdentique = false;

        if (isset($_POST["valider"])) {

            if (strlen($_POST["pseudo"]) < 5) {
                $erreurLongueurPseudo = true;
            } else if ($_POST['mot_de_passe'] != $_POST['confirmer_mot_de_passe']) {
                $erreurMotdePasseIdentique = true;
            } else {

                $connexion = new PDOperso();
                $requete = $connexion->prepare(
                    'INSERT INTO utilisateur (pseudo, mot_de_passe) VALUES (?,?)'
                );

                $requete->execute([
                    $_POST['pseudo'],
                    password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT)
                ]);

                header("Location: " . Conf::URL . "utilisateur/connexion");
            }
        }

        $parametres = compact('erreurLongueurPseudo', 'erreurMotdePasseIdentique');

        $this->afficherVue($parametres, 'inscription');
    }

    //edition utilisateur
    public function edition($id)
    {
        if (isset($_SESSION['droit']) && ($_SESSION['droit'] == "admin")) {

            $connexion = new PDOperso();

            //l'utilisateur a validé le formulaire
            if (isset($_POST['valider'])) {

                $requete = $connexion->prepare(
                    "UPDATE utilisateur
                    SET pseudo = ? , id_droit = ?
                    WHERE id = ?"
                );

                $requete->execute([
                    $_POST['pseudo'],
                    $_POST['droit'] == "" ? null : $_POST['droit'], //opérateur (ternaire) conditionnel 
                    $id
                ]);
            }

            //recuperation des droits
            $requete = $connexion->prepare(
                "SELECT * 
                FROM droit"
            );

            $requete->execute();
            $listeDroit = $requete->fetchAll();

            //recuperation de l'utilisateur
            $requete = $connexion->prepare(
                "SELECT *
                FROM utilisateur
                WHERE id = ?"
            );

            $requete->execute([$id]);
            $utilisateur = $requete->fetch();

            $parametres = compact('utilisateur', 'listeDroit');

            $this->afficherVue($parametres, 'edition');
        } else {
            header('Location: ' . \Conf::URL);
        }
    }

    //supprimer utilisateur
    public function supprimer($id)
    {
        if (isset($_SESSION['droit']) && ($_SESSION['droit'] == "admin")) {

            UtilisateurModele::deleteById($id);
      

            header('Location: ' . \Conf::URL . 'utilisateur/liste/');
        } else {
            header('Location: ' . \Conf::URL);
        }
    }

    public function deconnexion()
    {
        session_destroy();
        header("Location: " . Conf::URL);
    }
}
