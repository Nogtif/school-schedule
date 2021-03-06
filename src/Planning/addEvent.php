<?php 
namespace Planning;

// on implémente la base de donnée.
require_once('./config/pdo.php');
require_once('./src/App/FormValide.php');

use App\FormValide;

class addEvent extends FormValide {

    /** Constructeur de la classe addEvent.
     */
    public function __construct(\PDO $db, array $data) {
        parent::__construct($data);
        $this->bdd = $db;
    }

    /** Méthode qui valide
     */
    public function valideEvent() {
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
     * @param string $start > l'heure de fin du cour.
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


    /** Méthode qui insère un cours contenant les données reçu en paramètres.
     * @return bool : renvoie vrai si le cours à été ajouté, faux sinon.
     */
    public function createEvent():bool {
            
        // $sInsertEvent = $this->bdd->prepare('INSERT INTO Cours (DateCour, HeureDebut, HeureFin, MatiereID, UsagerID, TypeID, PromotionID, SalleID) VALUES (?,?,?,?,?,?,?,?)');
        // $sInsertEvent->execute([strtotime($this->data['dateCour']), $this->data['heureDebut'], $this->data['heureFin'], $this->data['matiere'], $this->data['enseignant'], $this->data['type'], $this->data['promotion'], $this->data['salle']]);
            
        return true;
    }
}