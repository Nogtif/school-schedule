<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/App/FormLogin.php');

// Si l'utilisateur est déjà connecté, on le redirige.
if(isOnline()) {
    header('Location: ./');
}

// Lors de la connexion...
if(isset($_POST['login'])) {

    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $form = new App\FormLogin($bdd, $_POST);
    $errors = $form->checkLogin();

	if(empty($errors)) {

        $sUsers = $bdd->prepare('SELECT * FROM Usagers WHERE UsagerID = ? LIMIT 0,1');
        $sUsers->execute([$_POST['userid']]);
        $aUser = $sUsers->fetch();

        $_SESSION['id'] = $aUser['UsagerID'];
        $_SESSION['password'] = $aUser['MotDePasse'];
        $_SESSION['nom'] = $aUser['Nom'];
        $_SESSION['prenom'] = $aUser['Prenom'];
        $_SESSION['rang'] = $aUser['RangID'];
        header('Location: ./');
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
            <form method="POST" id="form_login">
                <div class="form-group" id="userid">
                    <label for="identifiant">Identifiant</label>
                    <input type="text" name="userid" class="form-control <?= (isset($errors['userid']) ? ' is-invalid' : '') ?>" value="<?= (isset($_POST['userid']) ? htmlspecialchars($_POST['userid']) : '') ?>">
                    <?php if(isset($errors['userid'])) {
                        echo '<small class="invalid-feedback">'.htmlspecialchars($errors['userid']).'</small>';
                    } ?>
                </div>
                <div class="form-group" id="password">
                    <label for="mdp">Mot de passe</label>
                    <input type="password" name="password" class="form-control <?= (isset($errors['password']) ? ' is-invalid' : '') ?>" value="<?= (isset($_POST['password']) ? htmlspecialchars($_POST['password']) : '') ?>">
                    <?php if(isset($errors['password'])) {
                        echo '<small class="invalid-feedback">'.htmlspecialchars($errors['password']).'</small>';
                    } ?>
                </div>
                <input class="btn btn-primary" type="submit" name="login" value="Connexion">
            </form>
        </div>
    </div>
</body>
</html>
