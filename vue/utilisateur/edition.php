<form method="POST">
  <div class="container">
  <div class="row">
    <div class="col-6 form-group">
        <label for="pseudo" class="form-label mt-4">Pseudo</label>
        <input name="pseudo" value="<?= $utilisateur['pseudo']?>" type="text" class="form-control" id="pseudo" placeholder="pseudo">
     
        <label for="droit" class="form-label mt-4">Droit</label>
        <select class="form-select" id="droit">

          <option value="">Aucun droit</option>

          <?php foreach($listeDroit as $droit){ ?>
            <option <?php if($droit['id'] == $utilisateur['id_droit']) echo 'selected' ?> value="<?= $droit["id"] ?>"><?= $droit["denomination"] ?></option>
          <?php } ?>

        </select>

    </div>
  </div>
      <a class="btn btn-secondary mt-3" href="<?= Conf::URL ?>utilisateur/liste/">Annuler</a>
  </div> 
</form>