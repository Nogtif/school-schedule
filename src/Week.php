<?php 

namespace App;

/** Classe Week qui représente une semaine. */
class Week {

    // On déclare les variables...
    private $numWeek, $year, $firstDay;
    private $months = ['Janvier', 'Février', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Décembre'];
    private $days = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param string $date > la date courante.
     */
    public function __construct(int $week = null) {

        // Si la semaine est null ou trop éloignée, on met celle courante.
        if($week == null || $week < intval(date('W')) - 4 || $week > intval(date('W')) + 4) $week = intval(date('W'));

        // On affecte les valeurs.
        $this->numWeek = $week;
        $this->year = intval(date('Y'));
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

    public function getWeek():int {
        return $this->numWeek;
    }

    /** Méthode qui renvoie la date du premier jour de la semaine.
     * @return string : le premier jour.
     */
    public function getFirstDay():string {
        return $this->firstDay;
    }

    /** Méthode qui renvoie la date du dernier jour de la semaine.
     * @return string : le premier jour.
     */
    public function getLastDay():string {
        return $this->firstDay + (6 * 86400);
    }

    public function getDay(int $n):string {
        return $this->days[$n];
    }

    /** Méthode qui affiche la date donnée en paramètre.
     * @param string $day > le jour.
     * @return string : l'affichage au format date.
     */
    public function printDay(string $day):string {
        return date('l j/m/Y', $day);      
    }

    /** Méthode qui navigue vers la semaine précédente.
     */
    public function previousWeek():Week {
        return new Week($this->numWeek - 1);
    }

    /** Méthode qui navigue vers la semaine suivante.
     */
    public function nextWeek():Week {
        return new Week($this->numWeek + 1);
    }

    /** Méthode qui affiche une semaine.
     * @return string : la semaine.
     */
    public function toString():string {
        return $this->months[intval(date('m', $this->firstDay))-1]. ' '. date('j', $this->firstDay). ' - '. date('j', $this->getLastDay()). ', '. $this->year;
    }
}

?>