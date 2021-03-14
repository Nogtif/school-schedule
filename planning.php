<?php 
require_once('./config.php');
require_once('./src/Planning/Week.php');
require_once('./src/Planning/Events.php');

$week = new Planning\Week($_GET['week'] ?? null);
$events = new Planning\Events($bdd,$week->getFirstDay(), $week->getLastDay());
$mypromo = (isset($_SESSION['promo'])) ? $_SESSION['promo'] : 0;
$promo = (isset($_GET['promo'])) ? $_GET['promo'] : $mypromo;
?>

<h4 class="planning-title"><?= htmlspecialchars($week->toString()) ?></h4>
<div class="box-content">
<?= print_r($events->getEvents($promo)); ?>
    <table>
        <thead>
            <tr>
                <?php for($i = 0; $i < 7;$i++) { 
                    $day = $week->getFirstDay() + ($i * 86400);
                    echo '<td ' . ((intval(date('jm', $day)) == intval(date('jm', time()))) ? 'class="active"' : '') . '>';
                    echo '<span class="numDay">'. date('j', $day) .'</span>';
                    echo '<span class="nameDay">'. htmlspecialchars($week->getDay($i)) .'</span>';
                    echo '</td>';
                } ?>
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
        <?php foreach($events->getEvents($promo) as $events) { ?>
            <div class="events-day">
                <?php foreach($events as $event) { 
                    $top = (abs(strtotime(date("8:00")) - strtotime($event['HeureDebut'])) / 3600) * 70;
                    $height = (abs(strtotime($event['HeureFin']) - strtotime($event['HeureDebut'])) / 3600) * 70;

                    echo '<div class="event" style="background-color:'.$event['CouleurMatiere'].';top:'.$top.'px;height:'. $height.'px!important">';
                    echo '<span>'. str_replace(':', 'h', $event['HeureDebut']) .' - '. str_replace(':', 'h', $event['HeureFin']). '</span>';
                    echo '<b>'. $event['NomType'] . ' ' . htmlspecialchars($event['NomMatiere']). '</b>';
                    echo '<span>'. $event['NomSalle'] . ' ' . htmlspecialchars($event['Prenom']) . ' ' . htmlspecialchars($event['Nom']). '<span>';
                    echo '</div>';
                } ?>
            </div>
        <?php } ?>
    </div>
</div>