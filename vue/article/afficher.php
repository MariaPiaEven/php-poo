<article>

<h1><?= $article['titre'] ?></h1>

<p>
    <?= $article['contenu'] ?>
</p>

<img src="<?= Conf::URL?>assets/images/<?= $article['nom_image'] ?>">

</article>

<a href="<?= Conf::URL ?>article/liste" class="btn btn-primary">Retour</a>
