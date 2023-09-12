<?php require('../inc/init.inc.php'); 
if(!admin_est_connecte()){
    header("location: ../connexion.php");
}
if(!empty($_POST)){
    $photo_bdd="";
    if(!empty($_FILES['photo']['name'])){
        $nom_photo =$_POST['reference'] . '_' . $_FILES['photo']['name'];
        $photo_bdd ="public/img/$nom_photo";
        $photo_dossier ="../public/img/$nom_photo";
        copy($_FILES['photo']['tmp_name'],$photo_dossier);
    }
    foreach($_POST as $indice=>$valeur){
        $_POST[$indice] = htmlentities(addslashes($valeur));
    }
    executeRequete("INSERT INTO produit
    ( reference, categorie, titre, description, couleur, taille, public, photo, prix, stock)
    VALUES('$_POST[reference]', '$_POST[categorie]', '$_POST[titre]', '$_POST[description]', '$_POST[couleur]', '$_POST[taille]', '$_POST[public]', '$photo_bdd', '$_POST[prix]', '$_POST[stock]');");
    $contenu.='<div class ="validation">Le produit a bien été enregistré</div>';
}
//liens produits
$contenu.='<a href="?action=affichage">Affichage des produits</a>';
$contenu.='<a href="?action=ajout">Ajout d\'un produit</a>';
//affichage des produits
if(isset($_GET['action']) && $_GET['action']=== "affichage"){
    $resultat = executeRequete("SELECT * FROM produit");
    $contenu .= '<h2>Affichage des produits</h2>';
    $contenu .= 'Nombre de produits disponibles : ' . $resultat->num_rows;
    $contenu .= '<table border ="1"><tr>';
    while($colonne = $resultat->fetch_field()){
        $contenu .= '<th>' . $colonne->name . '</th>';

    }
    $contenu .= '<th>Modification</th>';
    $contenu .= '<th>Suppression</th>';
    $contenu .='</tr>';
    while($ligne = $resultat->fetch_assoc()){
        $contenu.='<tr>';
        foreach($ligne as $indice=>$informations){
            if($indice === "photo"){
                $contenu .= '<td><img src="' . RACINE_SITE . $informations . '" height ="70"></td>';
            } else {$contenu .= '<td>' . $informations . '</td>';}
        }
        $contenu .= '<td><a href="?action=modification&id_produit=' . $ligne['id_produit'] . '"><img src="../inc/assets/icons/edit.png"></a></td>';
        $contenu .= '<td><a href="?action=suppression&id_produit=' . $ligne['id_produit'] . '"OnClick="return(confirm(\'En etes vous certain ? \'));"><img src="../inc/assets/icons/delete.png"></a></td>';
        $contenu .= '</tr>'; 
    }
    $contenu .='</table>';
}
?>
<?php require('../inc/haut.inc.php'); 
echo $contenu;
if(isset($_GET['action']) && $_GET['action']=== "ajout"){
    echo '
<h1>Formulaire Produits</h1>
<form method="post" action="" enctype="multipart/form-data">
    <label for="reference">Référence</label><br>
    <input type="text" id="reference" name="reference" placeholder="La référence du produit"><br><br>
    <label for="categorie">catégorie</label><br>
    <input type="text" id="categorie" name="categorie" placeholder="la catégorie du produit"><br><br>
    <label for="titre">titre</label><br>
    <input type="text" id="titre" name="titre" placeholder="la description du produit"><br><br>
    <label for="description">description</label><br>
    <textarea name="description" id="description" placeholder="la description du produit"></textarea><br><br>
    <label for="couleur">couleur</label><br>
    <input type="text" id="couleur" name="couleur" placeholder="la couleur du produit"><br><br>
    <label for="taille">taille</label><br>
    <div><select name="taille">
        <option value="S">S</option>
        <option value="M">M</option>
        <option value="L">L</option>
        <option value="XL">XL</option>
    </select><br><br>
    <label for="public">public</label><br>
    <input type="radio" name="public" value="m" checked>Homme
    <input type="radio" name="public" value="f">Femme </div><br><br>
    <label for="photo">photo</label><br>
    <input type="file" name="photo" id="photo"><br><br>
    <label for="prix">prix</label><br>
    <input type="text" id="prix" name="prix" placeholder="le prix du produit"><br><br>
    <label for="stock">stock</label><br>
    <input type="text" id="stock" name="stock" placeholder="le stock du produit"><br><br>
    <input type="submit" value="enregistrement du produit">
</form> ';
}
?>

<?php require('../inc/bas.inc.php');
