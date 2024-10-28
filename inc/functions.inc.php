<!--toutes nos fonctions -->
<?php
function executeRequete($req){
    global $mysqli;
    try {
        $resultat = $mysqli->query($req);
        if(!$resultat){
            die('Erreur sur la requete SQL.<br>Message : ' . $mysqli->error . '<br>Code : ' . $req);
        }
        return $resultat;
    } catch (Exception $e) {
        return $e;
    }
}
//affichage de notre debogage
function debug($var, $mode = 1)
{
    echo '<div style="background: lightgrey; padding: 5px; float: right; clear: both; ">';
    $trace = debug_backtrace();
    $trace = array_shift($trace);
    echo "Debug demandé dans le fichier : $trace[file] à la ligne $trace[line].";
    if ($mode === 1) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
    } else {
        echo '<pre>';
        var_dump($var);
        echo '</pre>';
    }
    echo '</div>';
}
// savoir si un interaute est connecte
function internaute_est_connecte(){
    if(!isset($_SESSION['membre'])) return false;
    else return true;
}
// savoir si un admin est connecté
function admin_est_connecte(){
    if(internaute_est_connecte()&&$_SESSION['membre']['statut']==1) return true;
    else return false;
}