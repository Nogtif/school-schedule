<?php 

namespace App;

class Day {


    private $tabDays = ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];
    private $date, $day, $start, $end;

    /** Constructeur de la classe Day.
     * @param string $date : la date du jour.
     */    
    public function __construct(string $date) {
        $this->date = $date;
        $this->day = 'Lundi';
        $this->start = '08:00';
        $this->end = '20:00';
    }


    public function __toString() {
        return $this->day . ' '. date('j/m/y', $this->date);

    }
}

?>