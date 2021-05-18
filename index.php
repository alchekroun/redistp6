<?php
session_start();

require "coredis.php";

// Connexion à Redis
try {

    $redis = get_redis();

}
catch (Exception $e) {
    die($e->getMessage());
}

?>
<html lang="fr">
    <head>
        <title>Pendu</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    </head>
    <body>
        <div class="navbar navbar-light">
            <div class="col-4 d-flex right">
                <form action="deconnexion.php" method="get">
                    <button type="submit">Deconnexion</button>
                </form>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <?php if($_SESSION["online"] != true) { ?>
                        <form action="connexion.php" method="get">
                            <label for="pseudo">Pseudo : <input type="text" name="pseudo"/></label>
                            <button type="submit">Add</button>
                        </form>
                    <?php } else {
                        echo "<p> Bonjour ". $_SESSION["pseudo"] .", vous êtes connectés.</p>";
                    }?>
                </div>
                <div class="col-3">
                    <h4>Joueurs connectés</h4>
                    <?php
                        echo "<p>";
                        foreach ($redis->lrange('joueur', 0, -1) as $key) {
                            echo "Joueur : " . $key . "<br>";
                        }
                        echo "</p>";
                    ?>
                </div>
            </div>
            <div class="row">
                <?php
                    if($redis->exists('mot')){
                ?>
                    <div class="col-9">

                    </div>
                <?php
                    } else {
                ?>
                    <div class="col">
                        <p>Il n'y a aucun mot pour le moment, vous pouvez proposer un mot :</p>
                        <form action="proposition.php" method="get">
                            <input type="text" name="prop"/>
                            <input type="submit">
                        </form>
                    </div>
                <?php } ?>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>
