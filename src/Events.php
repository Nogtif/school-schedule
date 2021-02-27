<?php 
namespace App;
require_once('./config/pdo.php');

class Events {

    public function __construct($db) {
        $this->bdd = $db;
    }

    public function getEventsBetween(String $start, String $end):array {
        $events = [];
        $sPromo = $this->bdd->query('SELECT * FROM Programmer 
            INNER JOIN Cours ON Programmer.CourID = Cours.CourID 
            INNER JOIN Usagers ON Cours.EnseignantID = Usagers.UsagerID 
            LEFT JOIN Salles ON Programmer.SalleID = Salles.SalleID 
            LEFT JOIN TypeCours ON TypeCours.TypeID = Programmer.TypeID 
            WHERE DateCour BETWEEN ' .$start. ' AND ' . $end
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