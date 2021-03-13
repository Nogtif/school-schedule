<?php 
namespace Planning;
// on implémente les fichiers..
require_once('./config/pdo.php');
require_once('./src/App/Validator.php');

use App\Validator;

/** Classe qui hérite de Validator et s'occupe de la vérification des formulaire pour la gestion d'un cours.
*/
class FormEvent extends Validator {

    /** Constructeur de la classe FormEvent.
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
    public function checkEvent():array {
        $this->isValide('firstdate', 'checkDate');
        $this->isValide('nbweek', 'checkNbWeeks');
        $this->isValide('start', 'checkTimeMin');
        $this->isValide('end', 'checkTimeMax');
        $this->isValide('start', 'checkTime', 'end');
        $this->isValide('firstdate', 'timeSlotFree', 'start', 'end', 'matter');
        $this->isValide('firstdate', 'roomFree', 'start', 'end', 'room');
        // Vérification en plus, quand il s'agit de l'admin.
        $this->isValide('user', 'teachMatter', 'matter');
        return $this->errors;
    }

    /** Méthode qui vérifie si la date dans le tableau n'est pas passée.
     * @param string $name > clé de la date à vérifiée.
    */
    public function checkDate(string $name) {
        if(strtotime($this->data[$name]) < time()) {
            $this->errors[$name] = 'La première date du cours ne doit pas être passée !';
        }
    }

    /** Méthode qui vérifie si la date dans le tableau n'est pas passée.
     * @param string $name > clé de la date à vérifiée.
    */
    public function checkNbWeeks(string $name) {
        if($this->data[$name] < 1) {
            $this->errors[$name] = 'Le nombre de semaine ne peut être négatif !';
        }
    }

    /** Méthode qui vérifie si l'heure de début dans le tableau est bien supérieure à 8h00.
     * @param string $date > clé de l'heure de début à vérifiée.
    */
    public function checkTimeMin(string $date) {
        if($this->data[$date] < '08:00') {
            $this->errors[$date] = 'Les cours commencent à 8h00 !';
        }
    }

    /** Méthode qui vérifie si l'heure de fin dans le tableau est bien inférieure à 20h00.
     * @param string $hour > clé de l'heure de fin à vérifiée.
    */
    public function checkTimeMax(string $hour) {
        if($this->data[$hour] > '20:00') {
            $this->errors[$hour] = 'Les cours finissent à 20h00 !';
        }
    }

    /** Méthode qui vérifie si l'heure de début dans le tableau est bien inférieure à l'heure de fin.
     * @param string $startHour > clé de l'heure de fin à vérifiée.
     * @param string $endHour > clé de l'heure de fin à vérifiée.
    */
    public function checkTime(string $startHour, string $endHour) {
        if($this->data[$startHour] > $this->data[$endHour]) {
            $this->errors[$startHour] = 'L\'heure de début doit être inférieur à celle de fin !';
        }
    }

    /** Méthode qui verifie si un créneau pour une promotion est libre à cette date. 
     * @param string $date > la date du cours.
     * @param string $start > l'heure de début du cour.
     * @param string $end > l'heure de fin du cour.
     * @param string $promo > la promotion choisie.
     * @return bool : Vrai si le créneau est libre, faux sinon.
    */
    public function timeSlotFree(string $date, string $start, string $end, string $matter) {
        $opt = '';
        if(isset($this->data['id'])) {
            $opt = ' AND CourID != "'. $this->data['id'].'" ';
        }
        $cFree = $this->bdd->prepare('SELECT COUNT(*) FROM Cours INNER JOIN Matieres USING(MatiereID) WHERE DateDebut = :date AND (HeureDebut < :fin AND HeureFin > :debut) '.$opt.' AND PromotionID = (SELECT PromotionID FROM Matieres WHERE MatiereID = :matter)');
        $cFree->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':matter' => $this->data[$matter]));
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
        $opt = '';
        if(isset($this->data['id'])) {
            $opt = 'AND CourID != "'. $this->data['id'].'"';
        }
        $rFree = $this->bdd->prepare('SELECT COUNT(*) FROM Cours WHERE DateDebut = :date AND (HeureDebut < :fin AND HeureFin > :debut) AND SalleID = :salle '. $opt);
        $rFree->execute(array(':date' => strtotime($this->data[$date]), ':fin' => $this->data[$end], ':debut' => $this->data[$start], ':salle' => $this->data[$room]));
        $count = $rFree->fetchColumn();
        if($count > 0) {
            $this->errors['global'] = 'Le salle n\'est pas disponible !';
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

    /** Méthode qui insère un cours contenant les données reçu en paramètre.
     */
    public function insertEvent() {            
        $sInsertEvent = $this->bdd->prepare('INSERT INTO Cours (DateDebut, NbSemaines, HeureDebut, HeureFin, TypeID, SalleID, UsagerID, MatiereID) VALUES (?,?,?,?,?,?,?,?)');
        $sInsertEvent->execute([strtotime($this->data['firstdate']), $this->data['nbweek'], $this->data['start'], $this->data['end'], $this->data['type'], $this->data['room'], $this->data['user'], $this->data['matter']]);  
    }

    /** Méthode qui insère un cours contenant les données reçu en paramètre.
     */
    public function updateEvent() {            
        $sUpdateEvent = $this->bdd->prepare('UPDATE Cours SET DateDebut = ?, NbSemaines = ?, HeureDebut = ?, HeureFin = ?, TypeID = ?, SalleID = ?, UsagerID = ?, MatiereID = ? WHERE CourID = :id');
        $sUpdateEvent->execute([strtotime($this->data['firstdate']), $this->data['nbweek'], $this->data['start'], $this->data['end'], $this->data['type'], $this->data['room'], $this->data['user'], $this->data['matter'], ':id' => $this->data['id']]);  
    }

    /** Méthode qui supprime un cours.
     * @param int $id > l'id du cours.
     */
    public function deleteEvent(int $id) {
        $sDeleteEvent = $this->bdd->prepare('DELETE FROM Cours WHERE CourID = :id');
        $sDeleteEvent->execute([':id' => $id]);
    }
}