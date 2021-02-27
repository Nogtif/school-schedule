<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Week.php');
require_once('./src/EventsBetween.php');

if(!isOnline()) {
    header('Location: ./');
}

$week = new App\Week($_GET['week'] ?? null);
$events = new App\EventsBetween($bdd,$week->getFirstDay(), $week->getLastDay());

$promo = isset($_SESSION['promo']) ? $_SESSION['promo'] : 10;
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
                <div class="d-flex flex-row align-items-center justify-content-between">
                    <h1 class="calendar-title"><?= $week->toString(); ?></h1>

                    <div >
                        <a href="?week=<?= $week->previousWeek()->getWeek(); ?>" class="btn btn-primary<?php if($week->getWeek() == intval(date('W')) - 4) echo ' disabled' ?>"><i class="mdi mdi-chevron-left"></i></a>  
                        <a href="?week=<?= $week->nextWeek()->getWeek(); ?>" class="btn btn-primary<?php if($week->getWeek() == intval(date('W')) + 4) echo ' disabled' ?>"><i class="mdi mdi-chevron-right"></i></a>
                        
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
                </div>

                <div class="box-content">
                    <table>
                        <thead>
                            <tr>
                                <?php for($i = 0; $i < 7;$i++) { 
                                $day = $week->getFirstDay() + ($i * 86400);
                                ?>
                                <td <?php if(intval(date('jm', $day)) == intval(date('jm', time()))) echo 'class="active"'; ?>>
                                    <span class="numDay"><?= date('j', $day) ?></span>
                                    <span class="nameDay"><?= $week->getDay($i) ?></span>
                                </td>
                                <?php } ?>
                            </tr>
                        </thead>
                            <tbody>
                                <?php 
                                $pHour = new DatePeriod(new DateTime('08:00'), new DateInterval("PT30M"), 24);
                                $i = 0;
                                foreach($pHour as $dt) {
                                    echo '<tr><td class="hour"><span>';
                                    echo ($i%2!=0) ? $dt->format('H:i') : $dt->format('H:i');
                                    echo '</span></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
                                    
                                    $i++;
                                }
                                ?>
                            </tbody>
                        </div>
                    </table>

                    <div class="calendar-events">
                        <?php foreach($events->getEvents($promo) as $events) { ?>
                                
                            <div class="events-day">
                                <?php foreach($events as $event) { ?>
                                    <div class="event" style="background-color: <?= $event['CouleurMatiere'] ?>">
                                        <b><?= str_replace(':', 'h', $event['HeureDebut']) . ' ' . str_replace(':', 'h', $event['HeureFin']) ?></b>
                                        <span><?= $event['NomType'] . ' - ' . $event['NomMatiere'] ?></span>
                                        <span><?= $event['NomSalle'] ?></span>
                                        <span><?= $event['Prenom'] . ' ' . $event['Nom'] ?></span>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    
</body>
</html>
