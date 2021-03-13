<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'une salle de cours et des promotions.
*/
class FormOthers extends Validator {

    /** Constructeur de la classe FormOthers.
     * @param \PDO $db > la base de donnée.
     * @param array $data > le tableau contenant les données. 
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour ajouter une salle, 
     * @return array : le tableau d'erreurs.
     */
    public function checkAddRoom():array {
        $this->isValide('room', 'roomValide');
        $this->isValide('room', 'roomExist', false);

        return $this->errors;
    }

    /** Méthode qui renvoie toutes les erreurs trouvées pour ajouter une salle, 
     * @return array : le tableau d'erreurs.
     */
    public function checkDeleteRoom():array {
        $this->isValide('room', 'roomValide');
        $this->isValide('room', 'roomExist', true);
        return $this->errors;
    }

    /** Méthode qui renvoie toutes les erreurs trouvées pour ajouter une promotion, 
     * @return array : le tableau d'erreurs.
     */
    public function checkPromo():array {
        $this->isValide('name_promo', 'promoExist');
        return $this->errors;
    }

    /** Méthode qui vérifie si le champ correspondant à une salle est bien valide.
     * (Si elle commence par une lettre, et est suivie de chiffres).
     * @param string $name > l'indice dans la tableau.
     */
    public function roomValide(string $name) {
        if(!ctype_alpha($this->data[$name][0]) || !ctype_digit(substr($this->data[$name], 1))) {
            $this->errors[$name] = 'La salle n\'est pas valide !';
        }
    }

    /** Méthode qui vérifie si le nom de la nouvelle salle n'existe pas déjà.
     * @param string $name > le nom de la salle.
     */
    public function roomExist(string $name, bool $check) {
        $rExist = $this->bdd->prepare('SELECT COUNT(*) FROM Salles WHERE NomSalle = ?');
        $rExist->execute(array(strtoupper($this->data[$name])));
        $count = $rExist->fetchColumn();
        if($count > 0) {
            if($check == false) $this->errors[$name] = 'Cette salle existe déjà !';
        } else {
            if($check == true) $this->errors[$name] = 'Cette salle n\'existe pas !';
        }
    }

    /** Méthode qui vérifie si le nom de la nouvelle promotion n'existe pas déjà.
     * @param string $name > le nom de la promotion.
     */
    public function promoExist(string $name) {
        $pExist = $this->bdd->prepare('SELECT COUNT(*) FROM Promotions WHERE NomPromotion = ?');
        $pExist->execute(array(strtoupper($this->data[$name])));
        $count = $pExist->fetchColumn();
        if($count > 0) {
            $this->errors[$name] = 'Cette promotion existe déjà !';
        }
    }

    /** Méthode qui insère une salle.
     */
    public function insertRoom() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Salles (NomSalle) VALUES (?)');
        $sInsertEvent->execute([strtoupper($this->data['room'])]);  
    }

    /** Méthode qui supprime une salle de cours.
     */
    public function deleteRoom() {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Salles WHERE NomSalle = ?');
        $sDeleteEvent->execute(array(strtoupper($this->data['room'])));
    }

    /** Méthode qui insère une promotion.
     */
    public function insertPromo() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Promotions (NomPromotion, DepartementID) VALUES (?,?)');
        $sInsertEvent->execute([strtoupper($this->data['name_promo']), $this->data['depid']]);  
    }

    /** Méthode qui supprime une salle de cours.
     */
    public function deletePromo() {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Promotions WHERE PromotionID = ?');
        $sDeleteEvent->execute(array($this->data['promo']));
    }
}