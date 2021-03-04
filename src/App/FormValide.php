<?php 
namespace App;

abstract class FormValide {

    // On déclare quelques variables...
    protected $data, $errors;

    /** Constructeur de la classe FormValide.
     */
    public function __construct(array $data) {
        $this->data = $data;
        $this->errors = array();
    }

    public function getData() {
        return $this->data;
    }

    public function setData(string $ind, string $newData) {
        $this->data[$ind] = $newData;
    }

    public function validator() {
        return $this->errors;
    }

    /**
     */
    public function isValide(string $name, string $method, ...$param) {
        if(empty($this->data[$name])) {
            $this->errors[$name] = 'Le champ n\'est pas rempli !';
        } else {
            call_user_func([$this, $method], $name, ...$param);
        }
    }

    public function checkDate(string $name):bool {
        if(strtotime($this->data[$name]) < time()) {
            $this->errors[$name] = 'La date du cours ne doit pas être passée !';
            return false;
        }
        return true;
    }

    public function checkTimeMin(string $name):bool {
        if($this->data[$name] < '08:00') {
            $this->errors[$name] = 'Les cours commencent à 8h00 !';
            return false;
        }
        return true;
    }

    public function checkTimeMax(string $name):bool {
        if($this->data[$name] > '20:00') {
            $this->errors[$name] = 'Les cours finissent à 20h00 !';
            return false;
        }
        return true;
    }

    public function checkTime(string $heureDeb, $heureFin) {
        if($this->data[$heureDeb] > $this->data[$heureFin]) {
            $this->errors['global'] = 'L\'heure de début doit être inférieur à celle de fin !';
        }
    }

    public function checkSalle(string $name) {
        if(!ctype_alpha($this->data[$name][0]) || !ctype_digit(substr($this->data[$name], 1))) {
            $this->errors[$name] = 'La salle n\'est pas valide !';
        }
    }
}

?>