<?php

namespace controleur;

use Conf;
use modele\DroitModele;
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

            $listeUtilisateur = UtilisateurModele::findAllJoinDroit();

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

            $utilisateur = UtilisateurModele::findByPseudoJoinDroit($_POST['pseudo']);

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

                UtilisateurModele::create(
                    $_POST['pseudo'],
                    password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT));

                header("Location: " . Conf::URL . "utilisateur/connexion");
            }
        }

        $parametres = compact('erreurLongueurPseudo', 'erreurMotdePasseIdentique');

        $this->afficherVue($parametres, 'inscription');
    }

    //---- edition utilisateur ----
    public function edition($id)
    {
        if (isset($_SESSION['droit']) && ($_SESSION['droit'] == "admin")) {

            $connexion = new PDOperso();

            //---- l'utilisateur a validé le formulaire ----
            if (isset($_POST['valider'])) {

                UtilisateurModele::update(
                    $_POST['pseudo'],
                    $_POST['droit'] == "" ? null : $_POST['droit'], //opérateur (ternaire) conditionnel 
                    $id
                );
            }

            //---- recuperation des droits ----
            $listeDroit = DroitModele::findAll();

            //---- recuperation de l'utilisateur ----
            $utilisateur = UtilisateurModele::findById($id);

            //$parametres['listeDroit'] = $listeDroit;
            $parametres = compact('utilisateur', 'listeDroit');

            $this->afficherVue($parametres, 'edition');
        } else {
            header('Location: ' . \Conf::URL);
        }
    }

    //---- supprimer utilisateur ----
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
