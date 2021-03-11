<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Planning/FormRoom.php');

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
    $errorsRoom = $formRoom->checkAddRoom();

    // Si il n'y a aucune erreurs, on ajout le cours.
    if(empty($errorsRoom)) {
        if(isset($_POST['add_room'])){
            $formRoom->insertRoom();
        } 
    }
    if (isset($_POST['delete_room'])){
        $formRoom->deleteRoomByName($_POST['room']);
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

                    <?php if(isset($_POST['add_room']) && empty($errorsRoom)) {
                        echo '<div class="alert alert-success">La salle a bien été ajouté !</div>';
                    } ?>
                    <form method="POST" action="">
                        <label for="room">Nom de la salle</label>
                        <input type="text" name="room" class="form-control <?= (isset($errorsRoom['room'])) ? 'is-invalid' : '' ?>">
                        <?php if(isset($errorsRoom['room'])) {
                            echo '<div class="invalid-feedback">' . $errorsRoom['room'] . '</div>';
                        } ?>
                        <input type="submit" name="add_room" value="Ajouter" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="box-content">
                    <div class="content-title">Supprimer une salle</div>
                    <?php if(isset($_POST['delete_room']) && empty($errorsRoom)) {
                        echo '<div class="alert alert-success">La salle a bien été supprimé !</div>';
                    } ?>
                    <form method="POST" action="">
                        <label for="room">Nom de la salle</label>
                        <input type="text" name="room" class="form-control <?= (isset($errorsRoom['room'])) ? 'is-invalid' : '' ?>">
                        <?php if(isset($errorsRoom['room'])) {
                            echo '<div class="invalid-feedback">' . $errorsRoom['room'] . '</div>';
                        } ?>
                        <input type="submit" name="delete_room" value="Supprimer" class="btn btn-danger">
                    </form>
                </div>
            </div>
        </div>

        <p>Gestion des matières</p>

        <div class="row">
            <div class="col-md-4">
                <div class="box-content">
                    <div class="content-title">Ajouter une matière</div>
                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-8">
                                <label for="room">Nom de la matire</label>
                                <input type="text" name="room" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label for="room">Couleur</label>
                                <input type="color" name="room" class="form-control">
                            </div>
                        </div>

                        <input type="submit" name="add_room" value="Ajouter" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="col-md-8">
                <div class="box-content">
                    
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
