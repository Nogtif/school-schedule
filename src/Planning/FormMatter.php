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
        $this->isValide('nomM', 'matterExist');
        return $this->errors;
    }

    /** Méthode qui vérifie si le nom de la nouvelle matière n'existe pas déjà.
     * @param string $name > le nom de la matière.
     */
    public function matterExist(string $name) {
        $mExist = $this->bdd->prepare('SELECT COUNT(*) FROM Matieres WHERE NomMatiere = ?');
        $mExist->execute(array($this->data[$name]));
        $count = $mExist->fetchColumn();
        if($count > 0) {
            $this->errors['nomM'] = 'Cette matière existe déjà !';
        }  
    }

    /** Méthode qui insère insère une matière contenant les données reçu en paramètre.
     */
    public function insertMatter() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Matieres (NomMatiere, CouleurMatiere, PromotionID) VALUES (?,?,?)');
        $sInsertEvent->execute([$this->data['nomM'], $this->data['colorM'], $this->data['promoM']]);  
    }

    /** Méthode qui supprime une matière.
     * @param int $id > l'id de la matière.
     */
    public function deleteMatter($name) {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Matieres WHERE NomMatiere = :nomM');
        $sDeleteEvent->execute(array(':nomM' => $name));
    }
}