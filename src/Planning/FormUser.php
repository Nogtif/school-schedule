<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'une salle de cours.
*/
class Formuser extends Validator {

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
    public function checkAddUser():array {
        $this->isValide('userid', 'userExist');
        $this->isValide('password', 'checkPassword');
        $this->isValide('firstname', 'minLength', 3);
        $this->isValide('lastname', 'minLength', 3);
        return $this->errors;
    }

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function userExist(string $name) {
        $sUserExist = $this->bdd->prepare('SELECT COUNT(*) FROM Usagers WHERE UsagerID = ?');
        $sUserExist->execute(array($this->data[$name]));
        $count = $sUserExist->fetchColumn();
        if($count > 0) {
            $this->errors[$name] = 'Cet usager existe déjà !';
        } 
    }

    /** Méthode qui insère insère une salle contenant les données reçu en paramètre.
     */
    public function insertUser() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Usagers (UsagerID, MotDePasse, Nom, Prenom, RangID) VALUES (?,?,?,?,?)');
        $sInsertEvent->execute([$this->data['userid'], $this->data['password'], $this->data['lastname'], $this->data['firstname'], $this->data['rank']]);  
    }

    /** Méthode qui supprime une salle de cours.
     */
    public function deleteUser(string $id) {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Usagers WHERE UsagerID = ?');
        $sDeleteEvent->execute(array($id));
    }
}