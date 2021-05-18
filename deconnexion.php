<?php
session_start();

require "coredis.php";

$redis = get_redis();
$count = 0;
$redis->lrem('joueur', 1, $_SESSION['pseudo']);
/*
foreach($redis->lrange('joueur', 0, -1) as $key){
    if($key == $_SESSION['pseudo']){
        $redis->lrem('joueur', 1, $_SESSION['peusdo']);
    }
    $count++;
}*/

$_SESSION = array();
session_destroy();
header("Location: index.php");