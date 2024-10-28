<?php require_once("inc/init.inc.php");
// traitement
if(isset($_GET['action'])&&$_GET['action'] === "deconnexion"){
    session_destroy();
}
if(internaute_est_connecte()){
    header("location: profil.php");
}
if($_POST){
    $resultat = executeRequete("SELECT * FROM utilisateur WHERE pseudo ='$_POST[pseudo]'");
    if($resultat->num_rows!=0){
        //traitement connexion
        $membre = $resultat->fetch_assoc();
        if(password_verify($_POST['mot_de_passe'], $membre['mot_de_passe'])){
            foreach($membre as $indice=>$element){
                if($indice != 'mot_de_passe'){
                    $_SESSION['membre'][$indice] = $element;
                }
            }
            header("location: profil.php");
        }else { $contenu .='<div class ="erreur">erreur de mot de passe</div>';}
    } else {
        $contenu .='<div class ="erreur">Erreur de pseudo</div>';
    }
}
require_once("inc/haut.inc.php");
echo $contenu;
?>
<h2>connexion</h2>
<form method ="post" action="">
    <label for="pseudo">Pseudo</label>
    <input type="text" id="pseudo" name="pseudo"><br><br>
    <label for="mot_de_passe">Mot de passe</label>
    <input type="password" id ="mot_de_passe" name="mot_de_passe"><br><br>
    <button>Se connecter</button>
</form>
<?php require_once("inc/bas.inc.php");