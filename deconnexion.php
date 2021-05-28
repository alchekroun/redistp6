<?php
session_start();

require "coredis.php";

$redis = get_redis();
$count = 0;
$redis->lrem('joueur', 1, $_SESSION['pseudo']);

$_SESSION = array();
session_destroy();
header("Location: index.php");