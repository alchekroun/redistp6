<?php
session_start();

require 'coredis.php';

$redis = get_redis();

$proplettre = strtolower($_GET["proplettre"]);
if(isset($_GET["proplettre"])){
    $lettres = str_split($redis->get('mot'));

    if (in_array($proplettre, $lettres)){

        if (!in_array($proplettre, $redis->lrange('lettre', 0, -1))) {
            $nbOccurence = array_count_values($lettres);

            // Ajout
            for($i = 0; $i < $nbOccurence[$proplettre]; $i++) {
                $redis->rpush('lettre', $proplettre);
                $redis->expire('lettre', 60 - $redis->ttl('mot'));
            }  
        }
        if(sizeof($redis->lrange('lettre', 0, -1)) == strlen($redis->get('mot'))){
            $redis->set("lastword",  $redis->get('mot'));
            $redis->set("win", true);
            $redis->del(['mot', 'erreur', 'lettre', 'lettre_fausse']);
        }
    } else {
        if (!in_array($proplettre, $redis->lrange('lettre_fausse', 0, -1))) {

            $redis->rpush('lettre_fausse', $proplettre);
            $redis->expire('lettre_fausse', 60 - $redis->ttl('mot'));
            unset($_SESSION["message_deja_proposee"]);
        } else {
            $_SESSION["message_deja_proposee"] = "Lettre déjà proposée";
        }

        if(sizeof($redis->lrange('lettre_fausse', 0, -1)) >= 10) {
            $redis->set("win", false);
            $redis->del(['mot', 'erreur', 'lettre', 'lettre_fausse']);
        }
    }
}

header('Location: index.php');
