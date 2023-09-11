<?php require('../inc/init.inc.php'); 
if(!admin_est_connecte()){
    header("location: ../connexion.php");
}
?>
<?php require('../inc/haut.inc.php'); 

?>
<h1>Formulaire Produits</h1>
<form method="post" action="" enctype="multipart/form-data">
    <label for="reference">Référence</label>
    <input type="text" id="reference" name="reference" placeholder="La référence du produit">
    <button>Enregister le produit</button>
</form>


<?php require('../inc/bas.inc.php');
