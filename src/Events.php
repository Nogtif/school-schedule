<?php 
namespace Planning;

// on implémente la base de donnée.
require_once('./config/pdo.php');

/** Classe Events qui représente les événements (cours) au sein d'une semaine. */
class Events {

    // On déclare les variables...
    private $bdd, $firstDay, $lastDay;

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

    /** Méthode qui génère un tableau vide, indéxé sur les jours de la semaine.
     * @return array : le tableau semainier.
     */
    private function genereList():array {
        $events = array();
        for($i = 0; $i < 7; $i++) {
            $events[date('j', $this->firstDay + ($i * 86400))] = array();
        }
        return $events;
    }

    /** Méthode qui prend en paramètre une promotion, 
     * et va remplir le tableau de l'ensemble des cours correspondant à la promotion et à la semaine donnée.
     * @param string $promo > la promotion associé aux cours.
     * @return array : le tableau de cours rempli.
     */
    public function getEvents(string $promo):array {
        $events = $this->genereList();
        $sPromo = $this->bdd->query('SELECT * FROM Cours 
            INNER JOIN Matieres ON Cours.MatiereID = Matieres.MatiereID 
            INNER JOIN Promotions ON Matieres.PromotionID = Promotions.PromotionID 
            LEFT JOIN Usagers ON Cours.EnseignantID = Usagers.UsagerID 
            LEFT JOIN Salles ON Cours.SalleID = Salles.SalleID 
            LEFT JOIN TypeCours ON TypeCours.TypeID = Cours.TypeID 
            WHERE Promotions.PromotionID  = '. $promo.' AND DateCour BETWEEN '.$this->firstDay .' AND '.$this->lastDay. ' ORDER BY Cours.DateCour'
        );
        while($aPromo = $sPromo->fetch()) {
            $events[date('j', $aPromo['DateCour'])][] = $aPromo;               
        }
        return $events;
    }
}
?>