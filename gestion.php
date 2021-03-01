<!DOCTYPE html>
<?php 
require_once('./config.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login.php');
}

// Redirection vers l'index si l'usager n'est ni un enseignant, ni un administrateur.
if($_SESSION['rang'] < 2) {
    header('Location: ./');
}
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerer mes cours : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Gerer mes cours : Université d'Artois">
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

        <div class="row">
            <div class="col-md-7">
                <div class="box-content">

                </div>
            </div>
            <div class="col-md-5">    
                <div class="box-content">
                    <div class="content-title">Ajouter un cours</div>

                    <form method="POST" action="">

                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Promotion</label>
                                <select name="promotion" class="form-control">
                                
                                </select>
                            </div>

                            
                            <div class="col-md-6">
                                
                                <label for="">Matière</label>
                                <select name="matiere" id="" class="form-control">
                                    <option value="1">COO</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date du cours</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                            </div>

                            
                            <div class="col-md-6">
                                
                            </div>
                        </div>

                        <input type="submit" name="add_cours" value="Ajouter ce cours" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
        
    </div>

    <!-- FOOTER -->
    <?php require_once('./views/footer.php') ?>
    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
</body>
</html>
