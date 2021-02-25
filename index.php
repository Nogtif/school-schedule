<!DOCTYPE html>
<?php 
$msg_error = '';

?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Authentification : Université d'Artois">
    <meta property="og:type" content="website">
    <meta name="author" content="Carpentier Quentin & Krogulec Paul-Joseph">
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <div class="wrapper">
        <div class="content login">
            <h2>Service d'Authentification</h2>
            <form method="post" action="index.php">
                <label for="username">Identifiant</label>
                <input type="text" name="username" required>
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" required>
                <input class="btn btn-primary" type="submit" name="mylogin" value="Connexion">
            </form>
            <span><?= $msg_error; ?></span>
        </div>
    </div>
</body>
</html>
