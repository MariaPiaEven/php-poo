
<?php

session_start();

include('Autoloader.php');
Autoloader::start();

// new ArticleControleur();

// include('controleur/ArticleControleur.php');
// include('controleur/PageControleur.php');

// System MVC pour organiser les fichier

// ex: http://localhost/php-poo/index.php?chemin=article/liste/afficher/42
$chemin = $_GET['chemin'];
$partiesChemin = explode("/", $chemin);

// var_dump($partiesChemin);

// si l'utilisateur a fourni la premiere partie de l'url (le controleur)
if(isset($partiesChemin[0]) && $partiesChemin[0] != ""){
   // uppercasse first pour mettre la premier lettre en majuscule
    $nomControleur = "controleur\\" .ucfirst($partiesChemin[0])."Controleur";//ex:controleur/ArticleControleur
}else{
    $nomControleur = "controleur\\ArticleControleur";
}

// si l'utilisateur a fourni la seconde partie de l'url (l'action)
//sinon l'action sera liste par defaut
if(isset($partiesChemin[1]) && $partiesChemin[1] != ""){
    $nomAction = $partiesChemin[1];//ex:liste
 }else{
    $nomAction = "liste";
 }


//si l'urlcomporte un parametre, et que celle-ci finit pas par un slash
//ex: localhost/article/afficher/42
//note : localhost/article/afficher/ ne marche pas.
if(isset($partiesChemin[2]) && $partiesChemin[2] !=""){
    $parametre = $partiesChemin[2];//ex:42
}else {
    $parametre = null;
}

// Si la classe et sa methode existe
if(!method_exists($nomControleur, $nomAction)){

    $nomControleur="controleur\\PageControleur";
    $nomAction="PageNonTrouve";
}

$controleur = new $nomControleur();

//article -> ArticleControlleur

// if($nomControlleur == "article"){
//     $controlleur = new ArticleControlleur();

//     if($nomAction=="liste"){
//         $controlleur->liste();
//     }

// }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/php-poo/assets/css/bootstrap.min.css">
    <script defer src="/php-poo/assets/js/bootstrap.min.js"></script>
    <link defer rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- <script defer src="https://kit.fontawesome.com/92bbcd5c5d.js" crossorigin="anonymous"></script> -->


    <title>Document</title>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="<?= Conf::URL ?>">Super blog</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="nav-link active" href="<?= Conf::URL ?>">Accueil
            <span class="visually-hidden">(current)</span>
          </a>
        </li>

        <?php 
        if(isset($_SESSION['pseudo'])){
        ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/deconnexion">Deconnexion</a>
          </li>

        <?php
        } else {
        ?>
          <li class="nav-item">
            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/connexion">Connexion</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= Conf::URL ?>utilisateur/inscription">Inscription</a>
          </li>
        <?php
        }
        ?>
      
      </ul>
      <form class="d-flex" action="<?= Conf::URL?>article/recherche">
        <input name="recherche" class="form-control me-sm-2" type="text" placeholder="Titre, contenu, article">
        <button class="btn btn-secondary my-2 my-sm-0" type="submit"><i class="fa-solid fa-magnifying-glass"></i></button>
      </form>
    </div>
  </div>
</nav>

<?php
 $controleur->$nomAction($parametre);
?>


</body>
</html>
  