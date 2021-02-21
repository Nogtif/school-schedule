<?php 

namespace App;

class Semaine {

    private $date, $day, $start, $end;
 
    public function __construct(string $date) {
        $this->date = $date;
        $this->day = 'Lundi';
        $this->start = '08:00';
        $this->end = '20:00';
    }

    public function getWeeks(): int {
        return 0;

    }

    public function __toString(): string {
        return $this->day . ' '. date('j/m/y', $this->date);

    }
}

?>