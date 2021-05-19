<?php
session_start();

require 'coredis.php';

$redis = get_redis();

if(isset($_GET["proplettre"])){
    $lettres = str_split($redis->get('mot'));
    if (in_array($_GET["proplettre"], $lettres)){
        if (!in_array($_GET["proplettre"], $redis->lrange('lettre', 0, -1))) {
            $redis->rpush('lettre', strtolower($_GET["proplettre"]));
        }
        if(sizeof($redis->lrange('lettre', 0, -1)) == strlen($redis->get('mot'))){
            $_SESSION["lastword"] = $redis->get('mot');
            $_SESSION["win"] = true;
            $redis->del(['mot', 'erreur', 'lettre']);
        }
    } else {
        $redis->incr('erreur');
        if($redis->get('erreur') == 1){
            $redis->expire('erreur', 60);
        } else if($redis->get('erreur') >= 10) {
            $_SESSION["win"] = false;
            $redis->del(['mot', 'erreur', 'lettre']);
        }

    }
}

header('Location: index.php');
