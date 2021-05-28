<?php
session_start();

require 'coredis.php';

$redis = get_redis();

if(isset($_GET["prop"])){
    $redis->del(['mot', 'erreur', 'lettre', 'lettre_fausse']);
    $redis->set('mot', strtolower($_GET["prop"]));
    $redis->expire('mot', 60);
}

header('Location: index.php');
