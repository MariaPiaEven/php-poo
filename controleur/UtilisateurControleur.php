<?php

namespace controleur;

class UtilisateurControleur extends BaseControleur {

    public function liste(){
        $connexion = new \PDOperso();

        $requete = $connexion->prepare("SELECT * FROM utilisateur");
        $requete ->execute();
        $listeUtilisateur = $requete->fetchAll(); 
        $parametres = compact('listeUtilisateur');

        // $this->afficherVue('listeUtilisateur');
        $this->afficherVue($parametres);

    }
}

?>