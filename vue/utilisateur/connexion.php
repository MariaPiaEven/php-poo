<form method="POST">

    <div class="form-group">
        <label class="col-form-label mt-4" for="inputDefault">Pseudo</label>
        <input value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" name="pseudo" type="text" class="form-control" placeholder="Ex : John Doe" id="pseudo">
    </div>

    <div class="form-group">
        <label for="mot_de_passe" class="form-label mt-4">Mot de Passe</label>
        <input name="mot_de_passe" type="password" class="form-control" id="mot_de_passe">
    </div>

    <?php if($erreurPseudo){ ?>
        <p class="text-danger">Le pseudo ou le mot de passe n'existe pas</p>
    <?php } ?>

    <input name="valider" class="btn btn-primary mt-4" type="submit" value="Inscription">
    <a class="btn btn-warning mt-4" href="<?= Conf::URL ?>">Annuler</a>

</form>