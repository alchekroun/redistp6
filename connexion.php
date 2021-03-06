<?php
session_start();

require 'coredis.php';

$redis = get_redis();

$_SESSION["online"] = true;
$_SESSION["pseudo"] = $_GET["pseudo"];

$redis->rpush('joueur', $_GET["pseudo"]);
$redis->expire('joueur', 1800);

header('Location: index.php');