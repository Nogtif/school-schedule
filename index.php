<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Week.php');
require_once('./src/Events.php');

if(!isOnline()) {
    header('Location: ./login.php');
}

$nbWeek = date('W');

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
        <div class="main-grid">
            <div class="list-ressources">
                <!-- à remplir-->
            </div>

            <div id="navigation-calendar" class="calendar">

                <div class="planning-tools">
                    <a href="JavaScript:Void(0)" data-id="<?= $nbWeek - 1 ?>" class="btn btn-primary previousPage"><i class="mdi mdi-chevron-left"></i></a>  
                    <a href="JavaScript:Void(0)" data-id="<?= $nbWeek + 1 ?>" class="btn btn-primary nextPage"><i class="mdi mdi-chevron-right"></i></a>
                    
                    <select name="promo" class="form-select">
                        <option value="default">Promotions</option>
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

                <div id="target-content">

                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once('./views/footer.php') ?>

    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>

    <script>
        $(document).ready(function() {
            $("#target-content").load("planning.php");
            var currentWeek = $(".nextPage").attr("data-id") - 1;
            $(".btn").click(function(){
                var id = $(this).attr("data-id");
                $.ajax({
                    url: "planning.php",
                    type: "GET",
                    data: {
                        week : id
                    },
                    cache: false,
                    success: function(dataResult){
                        $("#target-content").html(dataResult);
                        $(".previousPage").attr("data-id", (currentWeek - 4 <= id - 1 ) ? id - 1 : id);
                        $(".nextPage").attr("data-id", (currentWeek + 4 >= (parseInt(id) + 1)) ? (parseInt(id) + 1).toString() : id);
                    }
                });
            });
        });
    </script>
    
</body>
</html>
