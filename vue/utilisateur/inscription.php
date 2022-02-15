<form method="POST">

    <div class="form-group">
        <label class="col-form-label mt-4" for="inputDefault">Pseudo</label>
        <input value="<?php if(isset($_POST['pseudo'])) echo $_POST['pseudo']; ?>" name="pseudo" type="text" class="form-control" placeholder="Ex : John Doe" id="pseudo">
    </div>

    <?php if($erreurLongueurPseudo){ ?>
        <p class="text-danger">Le pseudo doit avoir au moins 5 caractères</p>
    <?php } ?>

    <div class="form-group">
        <label for="mot_de_passe" class="form-label mt-4">Mot de Passe</label>
        <input name="mot_de_passe" type="password" class="form-control" id="mot_de_passe">
    </div>

    <div class="form-group mb-3">
        <label for="confirmer_mot_de_passe" class="form-label mt-4">Confirmer le mot de passe</label>
        <input name="confirmer_mot_de_passe" type="password" class="form-control" id="confirmer_mot_de_passe">
    </div>

    <?php if($erreurMotdePasseIdentique){ ?>
        <p class="text-danger">Les mots de passe sont différentes</p>
    <?php } ?>

    <input name="valider" class="btn btn-primary" type="submit" value="Inscription">
    <a class="btn btn-warning" href="<?= Conf::URL ?>">Annuler</a>
</form>