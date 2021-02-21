<?php 

namespace App;

/** Classe Week qui représente une semaine. */
class Week {

    // On déclare les variables...
    private $currentDay, $firstDay;

    /** Constructeur de la classe Week qui modélise une semaine.
     * @param string $date > la date courante.
     */
    public function __construct(?string $date) {
        $this->currentDay = $date;
        $this->firstDay = Week::getMonday($date);
    }

    /** Méthode qui calcul la date du premier jour de la semaine en fonction de celle donnée en paramètre.
     * @param string $day
     * @return string : renvoie la date du premier jour de la semaine
     */
    private static function getMonday(string $day):string {
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
}

?>