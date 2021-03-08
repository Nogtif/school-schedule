<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'un cours.
*/
class FormEvent extends Validator {

    /** Constructeur de la classe addEvent.
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
    public function checkAddEvent():array {
        $this->isValide('dateCour', 'checkDate');
        $this->isValide('heureDebut', 'checkTimeMin');
        $this->isValide('heureFin', 'checkTimeMax');
        $this->isValide('heureDebut', 'checkTime', 'heureFin');
        $this->isValide('dateCour', 'timeSlotFree', 'heureDebut', 'heureFin', 'promotion');
        $this->isValide('dateCour', 'roomFree', 'heureDebut', 'heureFin', 'salle');
        // Vérification en plus, quand il s'agit de l'admin.
        $this->isValide('promotion', 'promoMatter', 'matiere');
        $this->isValide('enseignant', 'teachMatter', 'matiere');
        return $this->errors;
    }

    /** Méthode qui verifie si un créneau pour une promotion est libre à cette date. 
     * @param string $date > la date du cours.
     * @param string $start > l'heure de début du cour.
     * @param string $end > l'heure de fin du cour.
     * @param string $promo > la promotion choisie.
     * @return bool : Vrai si le créneau est libre, faux sinon.
    */
    public function timeSlotFree(string $date, string $start, string $end, string $promo) {
        $cFree = $this->bdd->prepare('SELECT COUNT(*) FROM Cours INNER JOIN Matieres USING(MatiereID) WHERE DateCour = :date AND (HeureDebut < :fin AND HeureFin > :debut) AND PromotionID = :promo');
        $cFree->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':promo' => $this->data[$promo]));
        $count = $cFree->fetchColumn();
        if($count > 0) {
            $this->errors['global'] = 'Le créneau n\'est pas disponible !';
        }
    }

    /** Méthode qui verifie si une salle est libre à cette date et ce créneau. 
     * @param string $date > la date du cours.
     * @param string $start > l'heure de début du cour.
     * @param string $end > l'heure de fin du cour.
     * @param string $salle > la salle voulue.
    */
    public function roomFree(string $date, string $start, string $end, string $room) {
        $rFree = $this->bdd->prepare('SELECT COUNT(*) FROM Cours WHERE DateCour = :date AND (HeureDebut < :fin AND HeureFin > :debut) AND SalleID = :salle');
        $rFree->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':salle' => $this->data[$room]));
        $count = $rFree->fetchColumn();
        if($count > 0) {
            $this->errors['global'] = 'Le salle n\'est pas disponible !';
        }
    }

    /** Méthode qui verifie si un enseignant enseigne bien la matière. 
     * @param string $user > l'enseignant.
    */
    public function promoMatter(string $promo, string $matter) {
        $tMatter = $this->bdd->prepare('SELECT COUNT(*) FROM Matieres WHERE PromotionID = :promo AND MatiereID = :matiere');
        $tMatter->execute(array(':promo' => $this->data[$promo], ':matiere' => $this->data[$matter]));
        $count = $tMatter->fetchColumn();
        if($count == 0) {
            $this->errors['global'] = 'Cette promotion n\'étudie pas ce cours !';
        }
    }

    /** Méthode qui verifie si un enseignant enseigne bien la matière. 
     * @param string $user > l'enseignant.
    */
    public function teachMatter(string $user, string $matter) {
        $tMatter = $this->bdd->prepare('SELECT COUNT(*) FROM Matieres INNER JOIN Enseigne USING(MatiereID) WHERE UsagerID = :enseignant AND MatiereID = :matiere');
        $tMatter->execute(array(':enseignant' => $this->data[$user], ':matiere' => $this->data[$matter]));
        $count = $tMatter->fetchColumn();
        if($count == 0) {
            $this->errors['global'] = 'Cet enseignant(e) ne s\'occupe pas de cette matière !';
        }
    }

    /** Méthode qui insère un cours contenant les données reçu en paramètres.
     */
    public function createEvent() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Cours (DateCour, HeureDebut, HeureFin, TypeID, SalleID, UsagerID, MatiereID) VALUES (?,?,?,?,?,?,?)');
        $sInsertEvent->execute([strtotime($this->data['dateCour']), $this->data['heureDebut'], $this->data['heureFin'], $this->data['type'], $this->data['salle'], $this->data['enseignant'], $this->data['matiere']]);  
    }
}