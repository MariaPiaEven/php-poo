
<?php foreach ($listeUtilisateur as $user){

?>

<div class="card text-white bg-info mb-3" style="max-width: 20rem;">
  <div class="card-header"><?= $user['pseudo'] ?></div>
  <div class="card-body">
    <h4 class="card-title"><?=($user["denomination"])?></h4>

    <?php 
        if($_SESSION['droit'] == 'admin'){
    ?>
     <a class="btn btn-primary" href="<?= Conf::URL ?>utilisateur/editer/<?= $user['id'] ?>">Editer</a>
    <?php
        }
    ?>
    
  </div>
</div>

<?php } ?>