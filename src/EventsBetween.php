<?php 
namespace App;
require_once('./config/pdo.php');

class EventsBetween {

    // On déclare les variables...
    private $db, $firstDay, $lastDay, $tabCours;

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param \PDO $db > la base de donnée.
     * @param string > le premier jour de la semaine.
     * @param string > le dernier jour de la semaine.
     */
    public function __construct(\PDO $db, string $firstDay, string $lastDay) {
        $this->bdd = $db;
        $this->firstDay = $firstDay;
        $this->lastDay = $lastDay;
    }

    public function getEvents(string $promo):array {
        $events = [];
        $sPromo = $this->bdd->query('SELECT * FROM Programmer 
            INNER JOIN Cours ON Programmer.CourID = Cours.CourID 
            INNER JOIN Promotions ON Programmer.PromotionID = Promotions.PromotionID 
            INNER JOIN Usagers ON Cours.EnseignantID = Usagers.UsagerID 
            LEFT JOIN Salles ON Programmer.SalleID = Salles.SalleID 
            LEFT JOIN TypeCours ON TypeCours.TypeID = Programmer.TypeID 
            WHERE Promotions.PromotionID  = \''. $promo.'\' AND DateCour BETWEEN '.$this->firstDay .' AND '.$this->lastDay
        );
        while($aPromo = $sPromo->fetch()) {
            if(!isset($events[$aPromo['DateCour']])) {
                $events[$aPromo['DateCour']] = [$aPromo];
            } else {
                $events[$aPromo['DateCour']][] = $aPromo;
            }
        }
        return $events;
    }
}
?>