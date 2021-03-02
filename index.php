<!DOCTYPE html>
<?php 
require_once('./config.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDT : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="EDT : Université d'Artois">
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
        <div class="planning">
            <div class="planning-tools">
                <a href="javascript:void(0)" data-id="<?= date('W') - 1 ?>" class="btn btn-primary previousPage"><i class="mdi mdi-chevron-left"></i></a>  
                <a href="javascript:void(0)" data-id="<?= date('W') + 1 ?>" class="btn btn-primary nextPage"><i class="mdi mdi-chevron-right"></i></a>
                
                <select name="promo" class="form-select">
                    <option value="0">Promotions</option>
                    <?php
                    $sPromo = $bdd->query('SELECT * FROM Promotions ORDER BY PromotionID');
                    while($aPromo = $sPromo->fetch()) {
                        if($_SESSION['promo'] == $aPromo['PromotionID']) {
                            echo '<option value="'.$aPromo['PromotionID'].'" selected>'.$aPromo['NomPromotion'].'</option>';
                        } else {
                            echo '<option value="'.$aPromo['PromotionID'].'">'.$aPromo['NomPromotion'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>

            <div class="planning-page"></div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once('./views/footer.php') ?>
    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/functions.js"></script>
</body>
</html>
