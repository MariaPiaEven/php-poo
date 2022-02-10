<form method="POST">

    <div class="form-group">
        <label class="col-form-label mt-4" for="titre">Titre</label>
        <input value="<?= $article['titre'] ?>" name="titre" type="text" class="form-control" placeholder="Titre de l'Article" id="titre">
    </div>

    <div class="form-group">
        <label for="contenu" class="form-label mt-4">Contenu</label>
        <textarea value="<?= $article['contenu'] ?>" name="contenu" class="form-control" id="contenu" rows="3"></textarea>
    </div>

    <div class="form-group">
        <label for="image" class="form-label mt-4">Image</label>
        <input value="<?= $article['nom_image'] ?>" name="image" class="form-control" type="file" id="image">
    </div>

    <input name="valider" class="btn btn-primary mt-5" type="submit" value="Ajouter l'article">

</form>

<a href="<?= Conf::URL ?>article/liste/" class="btn btn-primary">Retour</a>