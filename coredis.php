<?php

require "predis/autoload.php";
Predis\Autoloader::register();

function get_redis()
{
    return new Predis\Client(
        array(
            "scheme" => "tcp",
            "host" => "localhost",//changer le nom de la base
            "port" => 6379//changer le mot de passe de la base
        )
    );
}

function consoleLog($msg) {
    echo '<script type="text/javascript">' .
        'console.log(' . $msg . ')</script>';
}

function alert($msg) {
    echo '<script type="text/javascript">' .
        'alert(' . $msg . ')</script>';
}
