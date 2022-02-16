<div class="container text-center">
<article>

<h1 class="mt-3"><?= $article['titre'] ?></h1>
<legend>Ecrit par : <?= $article['pseudo'] ?></legend>

<?php foreach($listeCategorie as $categorie){ ?>
    <span class="badge bg-primary"><?= $categorie['nom'] ?></span>
<?php } ?>

<p>
    <?= $article['contenu'] ?>
</p>

<?php if ($article['nom_image'] != "" && $article['nom_image'] != null) {?>
    <img src="<?= Conf::URL?>assets/images/<?= $article['nom_image'] ?>">
<?php } ?>

</article>

<a href="<?= Conf::URL ?>article/liste" class="btn btn-primary mt-3">Retour</a>
</div>