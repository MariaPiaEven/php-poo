<?php
foreach($listeArticle as $article){
?>

<div class="card text-white bg-secondary mb-3" style="max-width: 20rem;">
  <div class="card-header">Header</div>
  <div class="card-body"> 
    <h4 class="card-title"><?= $article["titre"]?></h4>
    <p class="card-text"><?=$article["contenu"]?></p>
    <a href="<?= Conf::URL ?>article/afficher/<?= $article["id"] ?>" class="btn btn-primary">Voir plus</a>
    <a href="<?= Conf::URL ?>article/supprimer/<?= $article["id"] ?>" class="btn btn-warning">Supprimer</a>
  </div>
</div>

<?php
}