<?php
namespace controleur;

class BaseControleur {

    public function afficherVue($parametres = [], $vue = 'liste'){

        //$listeArticle = $parametres['listeArticle'];
        extract($parametres);

        $dossier = strtolower(substr(get_class($this),11, -10));

        // on va afficher le dossier vue
        include('vue/' . $dossier . '/'.$vue . '.php');
        // include('vue/liste.php');
    }
}

?>