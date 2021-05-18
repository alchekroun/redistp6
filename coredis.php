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
