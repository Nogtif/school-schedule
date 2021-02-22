<?php 

namespace App;

/** Classe Week qui représente une semaine. */
class Week {

    // On déclare les variables...
    private $currentDay, $firstDay, $numWeek;

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param string $date > la date courante.
     */
    public function __construct(?string $date = null) {

        if($date == null) $date = time();

        $this->currentDay = $date;
        $this->firstDay = $this->getStartWeek($date);
        $this->numWeek = date('W', $this->currentDay);
    }

    /** Méthode qui calcul la date du premier jour de la semaine en fonction de celle donnée en paramètre.
     * @param string $day > la date courante.
     * @return string : renvoie la date du premier jour de la semaine
     */
    private function getStartWeek(string $day):string {
        // Calcul de l'écart entre le jour actuel et le lundi.
        $rel = 1 - date('N', $day);
        return strtotime("$rel days", $day);
    }

    /** Méthode qui renvoie la date du premier jour de la semaine.
     * @return string : le premier jour.
     */
    public function getFirstDay():string {
        return $this->firstDay;
    }

    /** Méthode qui renvoie le jour courant.
     * @return string : le jour courant.
     */
    public function getCurrentDay():string {
        return $this->currentDay;
    }

    /** Méthode qui affiche la date donnée en paramètre.
     * @param string $day > le jour.
     * @return string l'affichage au format date.
     */
    public function printDay(string $day):string {
        return date('l j/m/Y', $day);      
    }

    public function toString():string {
        return 'S' .$this->numWeek. ' '. date('j/m/Y', $this->currentDay);
    }
}

?>