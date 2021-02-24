<!DOCTYPE html>
<?php 
require_once './src/Week.php';
$week = new App\Week($_GET['week'] ?? null);
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EDT : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Projet : Emploi du temps">
    <meta property="og:type" content="website">
    <meta name="author" content="Carpentier Quentin & Krogulec Paul-Joseph">
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

    <?php require_once('./views/header.php') ?>

    <div class="container">

        <div class="row">
            <div class="col-md-3 side-box">
                <div class="box-content">
                    <div class="content-title">Liste des ressources</div>
                </div>
            </div>
            
            <div class="col-md-9">
                <div id="navigation-calendar" class="calendar">
                    <div class="d-flex flex-row align-items-center justify-content-between">
                        <h1 class="calendar-title"><?= $week->toString(); ?></h1>
                        <div class="calendar-nav">
                            <a href="?week=<?= $week->previousWeek()->getWeek(); ?>" class="btn btn-primary<?php if($week->getWeek() == intval(date('W')) - 4) echo ' disabled' ?>">&lt;</a>
                            <a href="?week=<?= $week->nextWeek()->getWeek(); ?>" class="btn btn-primary<?php if($week->getWeek() == intval(date('W')) + 4) echo ' disabled' ?>">&gt;</a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
    
	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    
</body>
</html>
