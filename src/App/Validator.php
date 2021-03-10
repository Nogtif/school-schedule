<?php 
namespace App;
/** Classe abstraite qui s'occupe de la vérification d'un formulaire.
*/
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

    /** Méthode qui prend en parametre un nom, une méthode et d'autres paramètres et,
     * renvoie une erreur si le champ "name" n'est pas rempli, ou appelle la méthode pour vérifier ce champ.
     * @param string $name > le nom du champ.
     * @param string $method > la méthode à appelée.
     * @param void $param > les autres paramètres (name) en plus.
     */
    public function isValide(string $name, string $method, ...$param) {
        if(empty($this->data[$name])) {
            $this->errors[$name] = 'Le champ n\'est pas rempli !';
        } else {
            call_user_func([$this, $method], $name, ...$param);
        }
    }

    /** Méthode qui vérifie si le champ correspondant à une salle est bien valide.
     * (Si elle commence par une lettre, et est suivie de chiffres).
     * @param string $name > l'indice dans la tableau.
     */
    public function checkRoom(string $name) {
        if(!ctype_alpha($this->data[$name][0]) || !ctype_digit(substr($this->data[$name], 1))) {
            $this->errors[$name] = 'La salle n\'est pas valide !';
        }
    }
}

?>