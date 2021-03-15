<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'une salle de cours.
*/
class FormUser extends Validator {

    /** Constructeur de la classe FormRoom.
     * @param \PDO $db > la base de donnée.
     * @param array $data > le tableau contenant les données. 
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour ajouter un usager, 
     * @return array : le tableau d'erreurs.
     */
    public function checkAddUser():array {
        $this->isValide('userid', 'userExist');
        $this->isValide('password', 'checkPassword');
        $this->isValide('firstname', 'minLength', 3);
        $this->isValide('lastname', 'minLength', 3);
        return $this->errors;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour mettre à jour un usager, 
     * @return array : le tableau d'erreurs.
     */
    public function checkUpdateUser():array {
        $this->isValide('userid', 'userExist');
        $this->isValide('firstname', 'minLength', 3);
        $this->isValide('lastname', 'minLength', 3);
        return $this->errors;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour associer un usager et une promotion, 
     * @return array : le tableau d'erreurs.
     */
    public function checkAddLinkPromo():array {
        $this->isValide('promo', 'bindExist', 'userid', false);
        return $this->errors;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour dissocier un usager à une promotion, 
     * @return array : le tableau d'erreurs.
     */
    public function checkRemoveLinkPromo():array {
        $this->isValide('promo', 'bindExist', 'userid', true);
        return $this->errors;
    }

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function bindExist(string $promo, string $user, bool $check) {
        $bExist = $this->bdd->prepare('SELECT COUNT(*) FROM Appartient WHERE PromotionID = :m AND UsagerID = :u');
        $bExist->execute(array(':m' => $this->data[$promo], ':u' => $this->data[$user]));
        $count = $bExist->fetchColumn();
        if($count > 0) {
            if($check == false) $this->errors['global'] = 'Cet usager étudie déjà dans cette promotion !';
        } else {
            if($check == true) $this->errors['global'] = 'Cet usager n\'étudie pas dans cette promotion !';
        }
    }

    /** Méthode qui vérifie si un usager n'existe pas déjà dans la base de donnée.
     * @param string $name > l'identifiant de l'usager.
     */
    public function userExist(string $name) {
        $opt = '';
        if(isset($this->data['userid'])) {
            $opt = ' AND UsagerID != "'. $this->data['userid'].'" ';
        }
        $sUserExist = $this->bdd->prepare('SELECT COUNT(*) FROM Usagers WHERE UsagerID = ? ' .$opt);
        $sUserExist->execute(array($this->data[$name]));
        $count = $sUserExist->fetchColumn();
        if($count > 0) {
            $this->errors[$name] = 'Cet usager existe déjà !';
        } 
    }

    /** Méthode qui insère un usager avec les données reçus.
     */
    public function insertUser() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Usagers (UsagerID, MotDePasse, Nom, Prenom, RangID) VALUES (?,?,?,?,?)');
        $sInsertEvent->execute([$this->data['userid'], password_hash($this->data['password'], PASSWORD_DEFAULT), $this->data['lastname'], $this->data['firstname'], $this->data['rank']]);  
    }

    /** Méthode qui modifie un usager avec les données reçus.
     */
    public function updateUser() {            
        $sUpdateUser = $this->bdd->prepare('UPDATE Usagers SET UsagerID = ?, Nom = ?, Prenom = ?, RangID = ? WHERE UsagerID = :id');
        $sUpdateUser->execute([$this->data['userid'], $this->data['lastname'], $this->data['firstname'], $this->data['rank'], ':id' => $this->data['userid']]);  
    }

    /** Méthode qui supprime un usager avec son id passé en paramètre.
     * @param int $id > l'id de l'usager.
     */
    public function deleteUser(int $id) {
        $sDeleteUser = $this->bdd->prepare('DELETE FROM Usagers WHERE UsagerID = ?');
        $sDeleteUser->execute(array($id));
    }

    /** Méthode qui insère une association entre un usager et une promotion.
     */
    public function linkUserToPromo() {            
        $sAddLink = $this->bdd->prepare('INSERT INTO Appartient (PromotionID, UsagerID) VALUES (?,?)');
        $sAddLink->execute([$this->data['promo'], $this->data['userid']]);  
    }

    /** Méthode qui supprime l'association entre un usager et une promotion.
     */
    public function unlinkUserToPromo() {
        $sRemoveLink = $this->bdd->prepare('DELETE FROM Appartient WHERE PromotionID = :m AND UsagerID = :u');
        $sRemoveLink->execute(array(':m' => $this->data['promo'], ':u' => $this->data['userid']));
    }
}