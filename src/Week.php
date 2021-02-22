<?php 

namespace App;

/** Classe Week qui représente une semaine. */
class Week {

    // On déclare les variables...
    private $numWeek, $year, $firstDay;

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param string $date > la date courante.
     */
    public function __construct(?int $week = null, ?int $year = null) {

        // Si les valeurs sont null, on met celles courantes.
        if($week == null) $week = intval(date('W'));
        if($year == null) $year = intval(date('Y'));

        // On affecte les valeurs.
        $this->numWeek = $week;
        $this->year = $year;
        $this->firstDay = $this->getStartWeek();
    }

    /** Méthode qui renvoie la date du premier jour de la semaine.
     * @return string : le premier jour de la semaine.
     */
    private function getStartWeek():string {
        $firstDayInYear = date("N", mktime(0,0,0,1,1, $this->year));

        if($firstDayInYear < 5) {
            $shift =- ($firstDayInYear - 1) * 86400;
        } else {
            $shift = (8 - $firstDayInYear) * 86400;
        }
        if($this->numWeek > 1) $weekInSeconds=($this->numWeek - 1) * 604800; else $weekInSeconds = 0;
        $timestamp = mktime(0,0,0,1,1, $this->year) + $weekInSeconds + $shift;

        return $timestamp;
    }

    /** Méthode qui renvoie la date du premier jour de la semaine.
     * @return string : le premier jour.
     */
    public function getFirstDay():string {
        return $this->firstDay;
    }

    /** Méthode qui affiche la date donnée en paramètre.
     * @param string $day > le jour.
     * @return string l'affichage au format date.
     */
    public function printDay(string $day):string {
        return date('l j/m/Y', $day);      
    }

    /** Méthode qui affiche une semaine.
     * @return string : la semaine.
     */
    public function toString():string {
        return 'S' .$this->numWeek. ' '. date('j/m/Y', $this->firstDay);
    }
}

?>