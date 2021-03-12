<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'une matière.
*/
class FormMatter extends Validator {

    /** Constructeur de la classe FormMatter.
     * @param \PDO $db > la base de donnée.
     * @param array $data > le tableau contenant les données. 
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour ajouter une matière, 
     * @return array : le tableau d'erreurs.
     */
    public function checkAddMatter():array {
        $this->isValide('name', 'matterExist');
        return $this->errors;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour associer une matière et un enseignant, 
     * @return array : le tableau d'erreurs.
     */
    public function checkAddLinkMatter():array {
        $this->isValide('matiere', 'bindExist', 'enseignant', false);
        return $this->errors;
    }

    /** Méthode qui va renvoie toutes les erreurs trouvées pour dissocier une matière à un enseignant, 
     * @return array : le tableau d'erreurs.
     */
    public function checkRemoveLinkMatter():array {
        $this->isValide('matiere', 'bindExist', 'enseignant', true);
        return $this->errors;
    }

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function bindExist(string $matter, string $user, bool $check) {
        $bExist = $this->bdd->prepare('SELECT COUNT(*) FROM Enseigne WHERE MatiereID = :m AND UsagerID = :u');
        $bExist->execute(array(':m' => $this->data[$matter], ':u' => $this->data[$user]));
        $count = $bExist->fetchColumn();
        if($count > 0) {
            if($check == false) $this->errors['global'] = 'Cet enseignant enseigne déjà ce cours !';
        } else {
            if($check == true) $this->errors['global'] = 'Cet enseignant n\'enseigne pas ce cours !';
        }
    }

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function matterExist(string $name) {
        $mExist = $this->bdd->prepare('SELECT COUNT(*) FROM Matieres WHERE NomMatiere = ?');
        $mExist->execute(array($this->data[$name]));
        $count = $mExist->fetchColumn();
        if($count > 0) {
            $this->errors['name'] = 'Cette matière existe déjà !';
        }  
    }

    /** Méthode qui insère une matière contenant les données reçu en paramètre.
     */
    public function insertMatter() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Matieres (NomMatiere, CouleurMatiere, PromotionID) VALUES (?,?,?)');
        $sInsertEvent->execute([$this->data['name'], $this->data['color'], $this->data['promo']]);  
    }

    /** Méthode qui supprime une matière.
     * @param int $id > l'id de la matière.
     */
    public function deleteMatter($id) {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Matieres WHERE MatiereID = :id');
        $sDeleteEvent->execute(array(':id' => $id));
    }

    /** Méthode qui insère une association entre une matière et un usager.
     */
    public function linkMatterAndTeacher() {            
        $sLink = $this->bdd->prepare('INSERT INTO Enseigne (MatiereID, UsagerID) VALUES (?,?)');
        $sLink->execute([$this->data['matiere'], $this->data['enseignant']]);  
    }

    /** Méthode qui supprime une matière.
     * @param int $id > l'id de la matière.
     */
    public function unLinkMatterAndTeacher() {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Enseigne WHERE MatiereID = :m AND UsagerID = :u');
        $sDeleteEvent->execute(array(':m' => $this->data['matiere'], ':u' => $this->data['enseignant']));
    }
}