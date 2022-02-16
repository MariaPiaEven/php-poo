<?php

namespace controleur;

use Conf;
use PDOperso;

class UtilisateurControleur extends BaseControleur {

    public function liste(){
        $connexion = new \PDOperso();

        $requete = $connexion->prepare(
            "SELECT *
             FROM utilisateur
             LEFT JOIN droit ON utilisateur.id_droit = droit_id
             "
        );

        $requete ->execute();
        $listeUtilisateur = $requete->fetchAll(); 

        $parametres = compact('listeUtilisateur');

        // $this->afficherVue('listeUtilisateur');
        $this->afficherVue($parametres);
    }

    public function connexion(){

        $erreurPseudo = false;

        //si l'utilisateur valide la connexion
        if(isset($_POST['valider'])){

            $connexion = new PDOperso();

            $requete = $connexion->prepare(
                "SELECT * 
                FROM utilisateur 
                LEFT JOIN droit ON droit.id = utilisateur.id_droit
                WHERE pseudo = ?");

            $requete->execute([
                $_POST['pseudo']
            ]);
            // on récupére l'utilisateur ayant le pseudo saisi
            $utilisateur = $requete->fetch();
        
            //si l'utilisateur existe bien
            if($utilisateur){
                //si l'utilisateur a saisi un mot de passe compatible avec le mot passe crypte
                if(password_verify($_POST['mot_de_passe'],$utilisateur['mot_de_passe'])){

                        $_SESSION['id'] = $utilisateur['id'];
                        $_SESSION['pseudo'] = $utilisateur['pseudo'];
                        $_SESSION['droit'] = $utilisateur['denomination'];

                        header("Location: " . Conf::URL);

                }else {
                        //si l'utilisateur a saisi un mauvais mot de passe
                        $erreurPseudo = true;
                }
            }else{
                      //si l'utilisateur a saisi un mauvais Pseudo
                    $erreurPseudo = true;
            }
            
        }

        $parametres = compact('erreurPseudo');

        $this->afficherVue($parametres,'connexion');
    }

    public function inscription(){

        $erreurLongueurPseudo = false;
        $erreurMotdePasseIdentique = false;

        if(isset($_POST["valider"])){
 
            if(strlen($_POST["pseudo"])<5){
                $erreurLongueurPseudo = true;
            } else if ($_POST['mot_de_passe'] != $_POST['confirmer_mot_de_passe']){
                $erreurMotdePasseIdentique = true;
            } else {

                $connexion = new PDOperso();
                $requete= $connexion->prepare(
                    'INSERT INTO utilisateur (pseudo, mot_de_passe) VALUES (?,?)');
                
                $requete->execute([
                    $_POST['pseudo'],
                    password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT)
                ]);

                header("Location: " . Conf::URL . "utilisateur/connexion");
            }
        }

        $parametres = compact('erreurLongueurPseudo', 'erreurMotdePasseIdentique');

        $this->afficherVue($parametres,'inscription');
    }

    public function deconnexion()
    {
        session_destroy();
        header("Location: " . Conf::URL);
    }

}

?>