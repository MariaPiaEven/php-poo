<form method="POST" enctype="multipart/form-data">

    <div class="form-group">
        <label class="col-form-label mt-4" for="titre">Titre</label>
        <input value="<?= $article['titre'] ?>" name="titre" type="text" class="form-control" placeholder="Titre de l'Article" id="titre">
    </div>

    <?php

    if($erreurDoublon){
    ?>
    <p class="text-danger">Ce titre existe déjà</p>
    <?php } ?>

    <div class="form-group">
        <label for="contenu" class="form-label mt-4">Contenu</label>
        <textarea name="contenu" class="form-control" id="contenu" rows="3"><?= $article['contenu'] ?></textarea>
    </div>

    <?php
    if ($article["nom_image"] != null && $article["nom_image"] != ""){
        ?>
            <img style="max-width: 300px" src="<?= Conf :: URL ?>assets/images/<?= $article["nom_image"] ?>">
            <button name="suppression_image" type="submit" class="btn btn-danger">
                <i class="fa-solid fa-trash-can"></i>
            </button>
        <?php
    }
        ?>

    <div class="form-group">
        <label for="image" class="form-label mt-4">Image</label>
        <input name="image" class="form-control" type="file" id="image">
    </div>

    <input name="valider" class="btn btn-primary mt-5" type="submit" value="Enregistrer">
    <a href="<?= Conf::URL ?>article/liste/" class="btn btn-primary mt-5">Annuler</a>

</form>

