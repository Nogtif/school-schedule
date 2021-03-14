<?php 
namespace Planning;
// on implémente la base de donnée.
require_once('./config/pdo.php');

/** Classe Events qui représente les événements (cours) au sein d'une semaine. 
*/
class Events {
    // On déclare les variables...
    private $bdd, $firstDay, $lastDay;

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param \PDO $db > la base de donnée.
     * @param string $firstDay > le premier jour de la semaine.
     * @param string $lastDay > le dernier jour de la semaine.
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
            $events[date('j', $this->firstDay + ($i * 86400))%7] = array();
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
            INNER JOIN Matieres USING(MatiereID)
            LEFT JOIN Usagers USING(UsagerID) LEFT JOIN Salles USING(SalleID) LEFT JOIN TypeCours USING(TypeID) 
            WHERE PromotionID  = '. $promo.' AND ((DateDebut <= '.$this->firstDay .' AND (DateDebut + (NbSemaines * 604800)) >= ' .$this->lastDay. ')) ORDER BY DateDebut'
        );
        while($aPromo = $sPromo->fetch()) {
            $events[date('j', strtotime('+'.$aPromo['NbSemaines'].' weeks', $aPromo['DateDebut']))%7][] = $aPromo;
        }
        return $events;
    }
}
?>