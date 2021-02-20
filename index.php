<!DOCTYPE html>
<?php require_once './src/Day.php' ?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <nav class="navbar navbar-dark bg-primary mb-3">
        <a href="./" class="navbar-brand">EDT</a>
    </nav>

    <?php
    $day = new App\Day(time());
    echo $day->__toString();

    ?>



</body>
</html>
