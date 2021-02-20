<?php 

namespace App;

class Day {


    private $tabDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $date, $day;

    /** Constructeur de la classe Day.
     * @param string $date : la date du jour.
     */    
    public function __construct(string $date) {
        $this->date = $date;
        $this->day = 'Lundi';
    }


    public function __toString() {
        return $this->tabDays[$this->day - 1] . ' '. $this->date;

    }
}

?>