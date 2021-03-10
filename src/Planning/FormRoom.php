<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'une salle de cours.
*/
class FormRoom extends Validator {

    /** Constructeur de la classe FormRoom.
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
        $this->isValide('room', 'checkRoom');
        $this->isValide('room', 'roomExist');
        return $this->errors;
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

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function roomExist(string $name) {
        $rExist = $this->bdd->prepare('SELECT COUNT(*) FROM Salles WHERE NomSalle = ?');
        $rExist->execute(array($this->data[$name]));
        $count = $rExist->fetchColumn();
        if($count > 0) {
            $this->errors['room'] = 'Cette salle existe déjà !';
        }  
    }

    /** Méthode qui insère insère une salle contenant les données reçu en paramètre.
     */
    public function insertRoom() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Salles (NomSalle) VALUES (?)');
        $sInsertEvent->execute([$this->data['room']]);  
    }

    /** Méthode qui supprime une salle de cours.
     * @param int $id > l'id de la salle.
     */
    public function deleteRoom(int $id) {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Salles WHERE SalleID = :id');
        $sDeleteEvent->execute(array(':id' => $id));
    }
}