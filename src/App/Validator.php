<?php 
namespace App;

abstract class Validator {

    // On déclare quelques variables...
    protected $data, $errors;

    /** Constructeur de la classe FormValide.
     * @param array $data > tableau contenant les données.
     */
    public function __construct(array $data) {
        $this->data = $data;
        $this->errors = array();
    }

    /** Méthode qui renvoie le tableau de donnée.
     * @return array : le tableau de donnée.
     */
    public function getData():array {
        return $this->data;
    }

    /** Méthode qui met à jour une donnée du tableau.
     * @param string $ind > l'indice dans le tableau.
     * @param string $newData > la nouvelle donnée.
     */
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

    public function checkDate(string $name) {
        if(strtotime($this->data[$name]) < time()) {
            $this->errors[$name] = 'La date du cours ne doit pas être passée !';
        }
    }

    public function checkTimeMin(string $name) {
        if($this->data[$name] < '08:00') {
            $this->errors[$name] = 'Les cours commencent à 8h00 !';
        }
    }

    public function checkTimeMax(string $name) {
        if($this->data[$name] > '20:00') {
            $this->errors[$name] = 'Les cours finissent à 20h00 !';
        }
    }

    public function checkTime(string $heureDeb, string $heureFin) {
        if($this->data[$heureDeb] > $this->data[$heureFin]) {
            $this->errors[$heureDeb] = 'L\'heure de début doit être inférieur à celle de fin !';
        }
    }

    public function checkSalle(string $name) {
        if(!ctype_alpha($this->data[$name][0]) || !ctype_digit(substr($this->data[$name], 1))) {
            $this->errors[$name] = 'La salle n\'est pas valide !';
        }
    }
}

?>