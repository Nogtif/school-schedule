<?php 
namespace App;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion de l'Authentification.
*/
class FormLogin extends Validator {

    /** Constructeur de la classe FormLogin.
     * @param \PDO $db > la base de donnée.
     * @param array $data > le tableau contenant les données. 
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

     /** Méthode qui va renvoie toutes les erreurs trouvées pour ajouter un cours, 
     * @return array : le tableau d'erreurs.
     */
    public function checkLogin():array {
        $this->isValide('userid', 'userExist');
        $this->isValide('password', 'correctPassword');
        return $this->errors;
    }

    /** Méthode qui vérifie si un usager existe, et renvoie une erreur si il n'existe pas.
     * @param string $name > l'identifiant de l'usager.
     */
    public function userExist(string $name) {
        $sUserExist = $this->bdd->prepare('SELECT * FROM Usagers WHERE UsagerID = ?');
        $sUserExist->execute([$this->data[$name]]);
        $count = $sUserExist->fetch();
        if(!$count) {
            $this->errors[$name] = 'Cet usager n\'existe pas !';
        } 
    }

    /** Méthode qui vérifie si un usager existe, et renvoie une erreur si il n'existe pas.
     * @param string $name > l'identifiant de l'usager.
     */
    public function correctPassword(string $name) {
        $sUsers = $this->bdd->prepare('SELECT * FROM Usagers WHERE UsagerID = ?');
        $sUsers->execute([$this->data['userid']]);
        $aUser = $sUsers->fetch();
        
        if(!password_verify($this->data[$name], $aUser['MotDePasse'])) {
            $this->errors[$name] = 'Le mot de passe ne correspond pas !';
        }
    }
}
?>