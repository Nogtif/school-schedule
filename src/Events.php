<?php 
namespace App;
require_once('./config/pdo.php');

class Events {

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function getEventsBetween(String $start, String $end):array {
        $events = [];
        $sPromo = $this->bdd->query('SELECT * FROM Cours INNER JOIN Programmer ON Cours.CourID = Programmer.CourID INNER JOIN Usagers ON Cours.EnseignantID = Usagers.UsagerID WHERE DateCour BETWEEN ' .$start. ' AND ' . $end);
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