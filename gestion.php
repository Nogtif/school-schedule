<!DOCTYPE html>
<?php 
require_once('./config.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}

// Redirection vers l'index si l'usager n'est ni un enseignant, ni un administrateur.
if($_SESSION['rang'] < 2) {
    header('Location: ./');
}

$last_search = isset($_GET['search']) ? $_GET['search'] : ' ';
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
                    <form method="GET" action="" class="form-search">
                        <input type="text" name="search" placeholder="Rechercher un cours..." class="form-control">
                        <input type="submit" value="Rechercher" class="btn btn-primary">
                    </form>
                    <hr>
                    <?php 
                    $where = 'WHERE UsagerID="'. $_SESSION['id'] . '" AND NomMatiere LIKE \'%'. $last_search.'%\'';
                    $sCours = $bdd->query('SELECT * FROM Cours c INNER JOIN Matieres m USING(MatiereID) LEFT JOIN TypeCours USING(TypeID) '.$where.' ORDER BY DateCour DESC');
                    while($aCours = $sCours->fetch()) {
                        echo $aCours['NomType'] . ' ' . $aCours['NomMatiere'] .  '<br>';
                    } ?>   

                </div>
            </div>
            <div class="col-md-5">    
                <div class="box-content">
                    <div class="content-title">Ajouter un cours</div>

                    <form method="POST" action="">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="">Promotion</label>
                                <select name="promotion" class="form-control" id="promo">
                                    <?php 
                                    $sPromo = $bdd->query('SELECT p.* FROM Appartient pu INNER JOIN Promotions p USING(PromotionID) WHERE UsagerID="'.$_SESSION['id'].'"');
                                    while($aPromo = $sPromo->fetch()) {
                                        echo '<option value="'.$aPromo['PromotionID'].'">'.$aPromo['NomPromotion'].'</option>';
                                    } ?>                                
                                </select>
                            </div>                            
                            <div class="col-md-6">
                                
                                <label for="">Matière</label>
                                <select name="matiere" id="" class="form-control" id="matiere">
                                    <?php 
                                    $sMatieres = $bdd->query('SELECT DISTINCT m.* FROM Cours c INNER JOIN Matieres m USING(MatiereID) WHERE c.UsagerID="'.$_SESSION['id'].'"');
                                    
                                    while($aMatieres = $sMatieres->fetch()) {
                                        echo '<option value="'.$aMatieres['MatiereID'].'">'.$aMatieres['NomMatiere'].'</option>';
                                    } ?> 
                                </select>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Date</label>
                                    <input type="date" name="date" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Heure de début</label>
                                    <input type="time" name="date" class="form-control">
                                </div>
                            </div>                            
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Heure de fin</label>
                                    <input type="time" name="date" class="form-control">
                                </div>
                                
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date">Enseignant</label>
                                    <input type="text" name="date" class="form-control" value="<?= $_SESSION['prenom']. ' ' .$_SESSION['nom'] ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="date">Type de cours</label>
                                    <select name="type" class="form-control">
                                    <?php 
                                            $query = $bdd->query("SELECT * FROM TypeCours");
                                            while ($row = $query->fetch()){
                                                echo '<option value="' . $row['TypeID'].'">' . $row['NomType'] . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            
                            <div class="col-md-3">

                                <div class="form-group">
                                    <label for="salle">Salle</label>
                                    <input type="text" name="salle" class="form-control">
                                </div>
                                
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
