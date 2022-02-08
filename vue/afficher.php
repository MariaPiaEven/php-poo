<article>

<h1><?= $article['titre'] ?></h1>

<p>
    <?= $article['contenu'] ?>
</p>

</article>

<a href="<?= Conf::URL ?>article/liste" class="btn btn-primary">Retour</a>
