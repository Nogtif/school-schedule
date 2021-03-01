<?php 
require_once('./src/Week.php');
require_once('./src/Events.php');

$week = new Planning\Week($_GET['week'] ?? null);
$events = new Planning\Events($bdd,$week->getFirstDay(), $week->getLastDay());
$promo = isset($_SESSION['promo']) ? $_SESSION['promo'] : 10;
?>

<h1 class="planning-title"><?= $week->toString() ?></h1>
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

    <div class="planning-events">
        <?php $i = 1; foreach($events->getEvents($_GET['promo'] ?? $promo) as $events) { ?>
            <div class="events-day">
                <?php foreach($events as $event) { 
                    $top = (abs(strtotime(date("8:00")) - strtotime($event['HeureDebut'])) / 3600) * 70;
                    $height = (abs(strtotime($event['HeureFin']) - strtotime($event['HeureDebut'])) / 3600) * 70;
                    ?>
                    <div class="event" style="background-color: <?= $event['CouleurMatiere'] ?>;top: <?= $top ?>px;left:<?= $i-1 ?>px;margin-right: <?= $i ?>px;height: <?= $height ?>px!important;">
                        <span><?= str_replace(':', 'h', $event['HeureDebut']) . ' - ' . str_replace(':', 'h', $event['HeureFin']) ?></span>
                        <b><?= $event['NomType'] . ' - ' . $event['NomMatiere'] ?></b>
                        <span><?= $event['NomSalle'] . (isset($event['NomSalle']) ? ' : ' : '') ?>
                        <?= $event['Prenom'] . ' ' . $event['Nom'] ?></span>
                    </div>
                <?php } ?>
            </div>
        <?php $i++; } ?>
    </div>
</div>