<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Planning/FormEvent.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}

// Redirection vers l'index si l'usager n'est pas un administrateur.
if($_SESSION['rang'] < 3) {
    header('Location: ./');
}
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Administration : Université d'Artois">
    <meta property="og:type" content="website">
    <meta name="author" content="Carpentier Quentin & Krogulec Paul-Joseph">
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/icons.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <!-- HEADER -->
    <?php require_once('./views/header.php') ?>

    <!-- PAGE -->
    <div class="container">

        <h4>Administration</h4>

        <div class="row">
            
        </div>
        <!-- FOOTER -->
        <?php require_once('./views/footer.php') ?>
    </div>

    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
</body>
</html>
