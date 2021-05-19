<?php
session_start();

require 'coredis.php';

$redis = get_redis();

$_SESSION["nbLETTRE"] =$redis->lrange('lettre', 0, -1);
$_SESSION["mot"] =$redis->get('mot');


if(isset($_GET["proplettre"])){
    $lettres = str_split($redis->get('mot'));
    if (in_array($_GET["proplettre"], $lettres)){
        if (!in_array($_GET["proplettre"], $redis->lrange('lettre', 0, -1))) {
            $nbOccurence = array_count_values($lettres);
            //Ajout
            for($i = 0; $i < $nbOccurence[$_GET["proplettre"]]; $i++) {
                $redis->rpush('lettre', strtolower($_GET["proplettre"]));
            }  
        }
        if(sizeof($redis->lrange('lettre', 0, -1)) == strlen($redis->get('mot'))){
            $_SESSION["lastword"] = $redis->get('mot');
            $_SESSION["win"] = true;
            $redis->del(['mot', 'erreur', 'lettre']);
        }
    } else {
        $redis->incr('erreur');

        //Ajout
        if ($redis->get('erreur')==1) {
            $erreur = array($_GET["proplettre"]);
        }else{
            $erreur = $_SESSION["erreur"];
            array_push($erreur,$_GET["proplettre"]); 
        }
        $_SESSION["erreur"] = $erreur;
        if($redis->get('erreur') == 1){
            $redis->expire('erreur', 60);
        } else if($redis->get('erreur') >= 10) {
            $_SESSION["win"] = false;
            $redis->del(['mot', 'erreur', 'lettre']);
        }

    }
}

header('Location: index.php');
