<div class="container">
<div class="row">

<?php 

foreach ($listeUtilisateur as $user){

?>

<div class="col-4">
<div class="card text-white bg-info mb-3 mt-3" style="max-width: 20rem;">
  <div class="card-header"><?= $user['pseudo'] ?></div>
  <div class="card-body">
    <h4 class="card-title"><?=($user["denomination"])?></h4>

    <?php 
        if(isset($_SESSION['droit']) && $_SESSION['droit'] == 'admin'){
    ?>
     <a class="btn btn-warning" href="<?= Conf::URL ?>utilisateur/edition/<?= $user['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
     <a class="btn btn-secondary" href="<?= Conf::URL ?>utilisateur/supprimer/<?= $user['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
    <?php
        }
    ?>
    
  </div>
</div>
</div>

<?php } ?>

</div>
</div>