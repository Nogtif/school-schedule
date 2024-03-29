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

    /** Méthode qui prend en vérifie si la valeur dans le champ $name à une longueur d'au moins $size.
     * @param string $name > le nom du champ contenant la valeur.
     * @param int $size > la taille minimale à vérifiée.
     */
    public function minLength(string $name, int $size) {
        if(strlen($this->data[$name]) < $size) {
            $this->errors[$name] = 'Le champ doit contenent au moins ' . $size . ' caractères !';
        }
    }

    /** Méthode qui vérifie si un mot de passe est valide.
     * (compte au moins 6 caractères et n'a pas de caractère spéciaux)
     * @param string $name > le mot de passe.
     */
    public function checkPassword(string $name) {
        if(strlen($this->data[$name]) < 6 && preg_match('/[^a-zA-Z0-9-!@]/', $this->data[$name])) {
            $this->errors[$name] = 'Le mot de passe est trop court ou content des caractères non-autorisé !';
        }
    }
}
?>