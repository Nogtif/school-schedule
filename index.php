<!DOCTYPE html>
<?php 
require_once('./config.php');

// Si l'utilisateur est déjà connecté, on le redirige.
if(isOnline()) {
    header('Location: ./calendar.php');
}

// Variables globales
$msg_error = '';

// Lors de la connexion...
if(isset($_POST['mylogin']) && !empty($_POST['identifiant']) && !empty('mdp')) {

    // On vérifie si l'usager est bien enregistré.
    $verif = $bdd->prepare('SELECT * FROM Usagers WHERE UsagerID = ? LIMIT 0,1');
	$verif->execute(array($_POST['identifiant']));
    $userExist = $verif->fetch();

    // Si l'usager existe et que le mot de passe correspond, on le connecte.
    if($userExist && password_verify($_POST['mdp'], $userExist['MotDePasse'])) {

        $_SESSION['id'] = $userExist['UsagerID'];
        $_SESSION['password'] = $userExist['MotDePasse'];
        $_SESSION['nom'] = $userExist['Nom'];
        $_SESSION['prenom'] = $userExist['Prenom'];
        $_SESSION['rang'] = $userExist['RangID'];
        $_SESSION['promo'] = $userExist['PromotionID'];

        // Une fois l'usager connecté, on le redirige.
        header('Location: ./calendar.php');
    // Sinon, on affiche le message d'erreur.
    } else {
        $msg_error = 'Identifiant ou Mot de passe invalide !';
    }
}
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
            <form method="post" action="">
                <label for="identifiant">Identifiant</label>
                <input type="text" name="identifiant" required>
                <label for="mdp">Mot de passe</label>
                <input type="password" name="mdp" required>
                <input class="btn btn-primary" type="submit" name="mylogin" value="Connexion">
            </form>
            <span><?= $msg_error; ?></span>
        </div>
    </div>
</body>
</html>
