<?php 
namespace Planning;

// on implémente la base de donnée.
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

class addEvent extends Validator {

    /** Constructeur de la classe addEvent.
     * @param \PDO $db > la base de donnée.
     * @param array $data > le tableau contenant les données. 
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui va regarder si le formulaire est correctement rempli et ne possède pas d'erreurs.
     * @return array : le tableau d'erreurs.
     */
    public function checkAddEvent() {
        $this->isValide('dateCour', 'checkDate');
        $this->isValide('heureDebut', 'checkTimeMin');
        $this->isValide('heureFin', 'checkTimeMax');
        $this->isValide('heureDebut', 'checkTime', 'heureFin');
        $this->isValide('salle', 'checkSalle');
        $this->isValide('dateCour', 'creneauValide', 'heureDebut', 'heureFin', 'promotion');
        return $this->errors;
    }

    /** Méthode qui verifie si un créneau pour une promotion est libre à cette date. 
     * @param string $date > la date du cours.
     * @param string $start > l'heure de début du cour.
     * @param string $end > l'heure de fin du cour.
     * @param string $promo > la promotion choisie.
     * @return bool : Vrai si le créneau est libre, faux sinon.
    */
    public function creneauValide(string $date, string $start, string $end, string $promo) {
        $nbCours = $this->bdd->prepare('SELECT COUNT(*) FROM Cours WHERE DateCour = :date AND (HeureDebut < :fin AND HeureFin > :debut) AND PromotionID = :promo');
        $nbCours->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':promo' => $this->data[$promo]));
        $count = $nbCours->fetchColumn();
        if($count > 0) {
            $this->errors['global'] = 'Le créneau n\'est pas disponible !';
        }
    }

    /** Méthode qui verifie si une salle est libre à cette date et ce créneau. 
     * @param string $date > la date du cours.
     * @param string $start > l'heure de début du cour.
     * @param string $end > l'heure de fin du cour.
     * @param string $salle > la salle voulue.
     * @return bool : Vrai si la salle est libre, faux sinon.
    */
    public function creneauLibre(string $date, string $start, string $end, string $promo) {
        $nbCours = $this->bdd->prepare('SELECT COUNT(*) FROM Cours WHERE DateCour = :date AND (HeureDebut < :fin AND HeureFin > :debut) AND SalleID = :salle');
        $nbCours->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':promo' => $this->data[$promo]));
        $count = $nbCours->fetchColumn();
        if($count > 0) {
            $this->errors['global'] = 'Le créneau n\'est pas disponible !';
        }
    }

    /** Méthode qui insère un cours contenant les données reçu en paramètres.
     */
    public function createEvent() {
            
        // $sInsertEvent = $this->bdd->prepare('INSERT INTO Cours (DateCour, HeureDebut, HeureFin, MatiereID, UsagerID, TypeID, PromotionID, SalleID) VALUES (?,?,?,?,?,?,?,?)');
        // $sInsertEvent->execute([strtotime($this->data['dateCour']), $this->data['heureDebut'], $this->data['heureFin'], $this->data['matiere'], $this->data['enseignant'], $this->data['type'], $this->data['promotion'], $this->data['salle']]);  
    }
}