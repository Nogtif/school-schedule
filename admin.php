<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Planning/FormRoom.php');
require_once('./src/Planning/FormMatter.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}

// Redirection vers l'index si l'usager n'est pas un administrateur.
if($_SESSION['rang'] < 3) {
    header('Location: ./');
}

// Ajout ou suppression d'une salle
if(isset($_POST['add_room']) || isset($_POST['delete_room'])) {
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formRoom = new Planning\FormRoom($bdd, $_POST);

    if(isset($_POST['add_room'])) {
        $errorsARoom = $formRoom->checkAddRoom();
        if(empty($errorsARoom)) $formRoom->insertRoom();
    }

    if(isset($_POST['delete_room'])) {
        $errorsDRoom = $formRoom->checkDeleteRoom();
        if(empty($errorsDRoom)) $formRoom->deleteRoom();
    }
}
if (isset($_POST['add_matter']) || isset($_POST['delete_matter'])){
    
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formmatter = new Planning\FormMatter($bdd, $_POST);
    $errorsMatter = $formmatter->checkAddMatter();
    if(empty($errorsMatter)){
        if(isset($_POST['add_matter'])){
            $formmatter->insertMatter();
        }
    }
    if (isset($_POST['delete_matter'])){
        $formmatter->deleteMatter($_POST['nomM']);
    }
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

        <p>Gestion des salles</p>

        <div class="row">
            <div class="col-md-6">
                <div class="box-content">
                    <div class="content-title">Ajouter une salle</div>

                    <?php if(isset($_POST['add_room']) && empty($errorsARoom)) {
                        echo '<div class="alert alert-success">La salle a bien été ajouté !</div>';
                    } ?>
                    <form method="POST" action="">
                        <label for="room">Nom de la salle</label>
                        <input type="text" name="room" class="form-control <?= (isset($errorsARoom['room'])) ? 'is-invalid' : '' ?>">
                        <?php if(isset($errorsARoom['room'])) {
                            echo '<div class="invalid-feedback">' . $errorsARoom['room'] . '</div>';
                        } ?>
                        <input type="submit" name="add_room" value="Ajouter" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-content">
                    <div class="content-title">Supprimer une salle</div>
                    <?php if(isset($_POST['delete_room']) && empty($errorsDRoom)) {
                        echo '<div class="alert alert-success">La salle a bien été supprimé !</div>';
                    } ?>
                    <form method="POST" action="">
                        <label for="room">Nom de la salle</label>
                        <input type="text" name="room" class="form-control <?= (isset($errorsDRoom['room'])) ? 'is-invalid' : '' ?>">
                        <?php if(isset($errorsDRoom['room'])) {
                            echo '<div class="invalid-feedback">' . $errorsDRoom['room'] . '</div>';
                        } ?>
                        <input type="submit" name="delete_room" value="Supprimer" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>

        <p>Gestion des matières</p>

        <div class="row">
            <div class="col-md-6">
                <div class="box-content">
                    <div class="content-title">Ajouter une matière</div>
                    <?php if(isset($_POST['add_matter']) && empty($errorsMatter)) {
                        echo '<div class="alert alert-success">La salle a bien été ajouté !</div>';
                    } ?>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="room">Nom de la matière</label>
                                <input type="text" name="nomM" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="room">Nom de la promotion </label>
                                <select name="promoM" class="form-control">
                                <?php 
                                    $sPromo = $bdd->query('SELECT * FROM Promotions '.$option.' ORDER BY PromotionID');
                                    while($aPromo = $sPromo->fetch()) {
                                        echo '<option value="'.$aPromo['PromotionID'].'"'. ((isset($_POST['promotion']) && $_POST['promotion'] == $aPromo['PromotionID']) ? ' selected' : '') .'>'.$aPromo['NomPromotion'].'</option>';
                                    } ?>    
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label for="room">Couleur</label>
                                <input type="color" name="colorM" class="form-control">
                            </div>
                        </div>

                        <input type="submit" name="add_matter" value="Ajouter" class="btn btn-success">
                    </form>
                </div>
            </div>
            
            <div class="col-md-6">
                <div class="box-content">
                    <div class="content-title">Supprimer une matière</div>
                    <?php if(isset($_POST['delete_matter'])) {
                        echo '<div class="alert alert-success">La matière a bien été supprimé !</div>';
                    } ?>
                    <form method="POST" action="">
                        <label for="room">Nom de la matiére</label>
                        <input type="text" name="nomM" required class="form-control <?= (isset($errorsMatter['nomM'])) ? 'is-invalid' : '' ?>">
                        <?php if(isset($errorsRoom['room'])) {
                            echo '<div class="invalid-feedback">' . $errorsMatter['nomM'] . '</div>';
                        } ?>
                        <input type="submit" name="delete_matter" value="Supprimer" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>

        <p>Gestion des usagers</p>
        
            
    </div>

    <!-- FOOTER -->
    <?php require_once('./views/footer.php') ?>

	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
</body>
</html>
