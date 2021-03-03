<?php

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="index.css">
    <title>Exo complet lecture SQL.</title>
</head>
<body>

        <?php
        try{
            $server = 'localhost';
            $db = 'exo197';
            $user = 'root';
            $pass = '';

            $pdo = new PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pass);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // clients list
            $stmt = $pdo->prepare("SELECT firstName, lastName from clients");
            $state = $stmt->execute();

            if($state) {
                echo "<div>1 - Clients :<p>";
                foreach ($stmt->fetchAll() as $user) {
                    echo $user['firstName']." ".$user['lastName']."<br>";
                }
                echo "</p></div>";
            }

            // show types
            $stmt = $pdo->prepare("SELECT type from showtypes");
            $state = $stmt->execute();

            if($state) {
                echo "<div>2 - types de spectacle :<p>";
                foreach ($stmt->fetchAll() as $type) {
                    echo $type['type']."<br>";
                }
                echo "</p></div>";
            }

            // 20th first clients
            $stmt = $pdo->prepare("SELECT firstName, lastName from clients LIMIT 20");
            $state = $stmt->execute();

            if($state) {
                echo "<div>3 - 20th first clients :<p>";
                foreach ($stmt->fetchAll() as $user) {
                    echo $user['firstName']." ".$user['lastName']."<br>";
                }
                echo "</p></div>";
            }

            // card owners clients
            $stmt = $pdo->prepare("SELECT firstName, lastName from clients WHERE card = 1");
            $state = $stmt->execute();

            if($state) {
                echo "<div>4 - Card owners :<p>";
                foreach ($stmt->fetchAll() as $user) {
                    echo $user['firstName']." ".$user['lastName']."<br>";
                }
                echo "</p></div>";
            }

            // first letter name M
            $stmt = $pdo->prepare("SELECT * from clients WHERE lastName LIKE 'M%' ORDER BY lastName ASC ");
            $state = $stmt->execute();

            if($state) {
                echo "<div>5 - M :<p>";
                foreach ($stmt->fetchAll() as $user) {
                    echo "Nom : ".$user['lastName']."<br> Prénom : ".$user['firstName']."<br><br>";
                }
                echo "</p></div>";
            }

            // title - performer - date - time
            $stmt = $pdo->prepare("SELECT title, performer, date, startTime from shows ORDER BY title ASC");
            $state = $stmt->execute();

            if($state){
                echo "<div>6 - spectacles :<p>";
                foreach ($stmt->fetchAll() as $item) {
                    echo $item['title']." par ".$item['performer'].", le".$item['date']." à ".$item['startTime']."<br>";
                }
                echo "</p></div>";
            }

            // all clients information
            $stmt = $pdo->prepare("SELECT * from clients ORDER BY lastName ASC");
            $state = $stmt->execute();

            if($state) {
                echo "<div>7 - Informations clients  :<p>";
                foreach ($stmt->fetchAll() as $user) {
                    echo "Nom : ".$user['lastName']."<br> Prénom : ".$user['firstName']."<br> Date de naissance : ".$user['birthDate']."<br>Carte de fidélité : ";
                    $ref = $user['card'] == 0 ? "Non" : "Oui <br> Numéro de carte : ".$user['cardNumber'];
                    echo $ref."<br><br>";

                }
                echo "</p></div>";
            }
        }
        catch(PDOException $exception){
            echo $exception->getMessage();
        }
        ?>

</body>
</html>
