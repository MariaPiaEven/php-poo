<form method="POST">
<div class="container">
<div class="form-group">
      <label for="pseudo" class="form-label mt-4">Pseudo</label>
      <input name="pseudo" value="<?= $utilisateur['pseudo']?>" type="text" class="form-control" id="pseudo" placeholder="pseudo">
    </div>
   
    <div class="form-group">
      <label for="denomination" class="form-label mt-4">Denomination</label>
      <select class="form-select" id="denomination">
        <option>Admin</option>
        <option>Premium</option>
        <option>Redacteur</option>
      </select>
    </div>

    <a class="btn btn-secondary mt-3" href="<?= Conf::URL ?>utilisateur/liste/">Annuler</a>
    
</div>
</form>