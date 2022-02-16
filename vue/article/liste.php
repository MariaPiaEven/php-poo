
<div class="container">
  <div class="d-flex justify-content-center">
  
  <?php
    if(isset($_SESSION['pseudo'])) {
  ?>

    <a href="<?= Conf::URL ?>article/insertion" class="btn btn-primary m-3">Ajouter un article</a>

  <?php
    }
  ?>

  </div>

<div class="row">
<?php
foreach($listeArticle as $article){
?>

<div class="col-6">
  <div class="card text-white bg-secondary mb-3 mt-3">
    <div class="card-header">Ecrit par : <?= htmlentities($article["pseudo"])?></div>
      <div class="card-body"> 
        <h4 class="card-title"><?= htmlentities($article["titre"])?></h4>
      
        <?php
        if($article['nom_image']) {
        ?>
            <img class="img-fluid" src="<?= Conf::URL?>assets/images/<?= $article['nom_image'] ?>">
        <?php
        }
        ?>
        <!-- Pour eviter les textes mechants comme code js -->
        <p class="card-text"><?= htmlentities($article["contenu"])?></p>
        <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-primary">Voir plus</a>

        <?php
        //si l'utilisateur est connecté
        if(isset($_SESSION['id'])){

          //si il est administrateur ou il est l'auteur de l'article
          if($_SESSION['droit'] == "admin" || $_SESSION['id'] == $article["id_utilisateur"]){
                                  // admin denomination de la bdd sur droit

          // if ((isset($_SESSION['droit']) && $_SESSION['droit'] == "admin") 
                      //pour donner les droits d'edition a l'auteur de l'article
          // || (isset($_SESSION['id']) && $_SESSION['id'] == $article["id_utilisateur"])) {
        ?>
        
          <a href="<?= Conf::URL ?>article/edition/<?= $article["id"] ?>" class="btn btn-info"><i class="fa-solid fa-pen-to-square"></i></a>
          <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-trash-can"></i></a>
        <?php
        }
      }
        ?>
    </div>
  </div>
</div>

<?php
}
?>
</div>
</div>