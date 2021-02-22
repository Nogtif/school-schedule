<!DOCTYPE html>
<?php 
require_once './src/Week.php' 
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projet : Emploi du temps</title>
    <meta property="og:title" content="Projet : Emploi du temps">
    <meta property="og:type" content="website">
    <meta name="author" content="Carpentier Quentin & Krogulec Paul-Joseph">
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>

    <nav></nav>
    <?php
    $week = new App\Week($_GET['week'] ?? null, $_GET['year'] ?? null);
    ?>
    <table>
        <thead>
            <tr>
                <td>&nbsp;</td>
                <?php for($i = 0; $i < 7;$i++) { ?>
                    <td><?= $week->printDay($week->getFirstDay() + ($i * 86400)) ?></td>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
            <?php 
            $pHour = new DatePeriod(new DateTime('08:00'), new DateInterval("PT30M"), 24);
            $i = 0;
            foreach($pHour as $dt) {
                echo '<tr><td class="hour">';
                echo ($i%2!=0) ? $dt->format('H:i') : $dt->format('H:i');
                echo '</td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
            
                $i++;
            }
            ?>                
        </tbody>
    </table>

</body>
</html>
