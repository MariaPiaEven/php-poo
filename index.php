
<?php
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
    <title>Document</title>
</head>
<body>

<?php
 $controleur->$nomAction($parametre);
?>


</body>
</html>
  