<?php 
namespace Planning;

// on implémente la base de donnée.
require_once('./config/pdo.php');
require_once('./src/App/FormValide.php');

use App\FormValide;

class EventValide extends FormValide {

    /** Constructeur de la classe EventValide.
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui valide
     */
    public function validator() {
        $this->isValide('dateCour', 'checkDate');
        $this->isValide('heureDebut', 'checkTimeMin');
        $this->isValide('heureFin', 'checkTimeMax');
        $this->isValide('heureDebut', 'checkTime', 'heureFin');
        $this->isValide('salle', 'checkSalle');
        return $this->errors;
    }

    /** Méthode qui prend en paramètre un tableau de donnée,
     * et insérer un cours contenant les données reçu en paramètres.
     * @return bool : renvoie vrai si le cours à été ajouté, faux sinon.
     */
    public function createEvent():bool {

        $sInsertEvent = $this->bdd->prepare('INSERT INTO Cours (DateCour, HeureDebut, HeureFin, MatiereID, UsagerID, TypeID, PromotionID, SalleID) VALUES (?,?,?,?,?,?,?,?)');
        $sInsertEvent->execute([
            strtotime($this->data['dateCour']), $this->data['heureDebut'], $this->data['heureFin'],
            $this->data['matiere'], $this->data['enseignant'], $this->data['type'], $this->data['promotion'], $this->data['salle']
        ]);
        return true;
    }
}