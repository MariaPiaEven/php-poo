
<div class="container">
  <div class="d-flex justify-content-center">
  <a href="<?= Conf::URL ?>article/insertion" class="btn btn-primary m-3">Ajouter un article</a>
  </div>
<div class="row">
<?php
foreach($listeArticle as $article){
?>


<div class="card col-3 text-white bg-secondary mx-auto">
  <div class="card-header">Header</div>
    <div class="card-body"> 
    <h4 class="card-title"><?= $article["titre"]?></h4>
   
    <?php
    if($article['nom_image']) {
    ?>
        <img class="img-fluid" src="<?= Conf::URL?>assets/images/<?= $article['nom_image'] ?>">
    <?php
    }
    ?>
    
    <p class="card-text"><?=$article["contenu"]?></p>
    <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-primary">Voir plus</a>
    <a href="<?= Conf::URL ?>article/edition/<?= $article["id"] ?>" class="btn btn-primary"><i class="fa-solid fa-pen-to-square"></i></a>
    <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-warning"><i class="fa-solid fa-trash-can"></i></a>
  </div>
</div>

<?php
}
?>
</div>
</div>