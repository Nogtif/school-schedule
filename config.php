<?php 
session_start();
require_once(__DIR__.'/config/pdo.php');

// On importe les classes nécessaires pour la vérification des divers formulaires
require_once('./src/Planning/FormEvent.php');
require_once('./src/Planning/FormOthers.php');
require_once('./src/Planning/FormMatter.php');
require_once('./src/Planning/FormUser.php');

/** Fonction qui renvoie vrai si l'usager est connecté, faux sinon. */
function isOnline() {
	if(isset($_SESSION['id'])) {
		return true;
	}
    return false;
}

/** === Requête de la page Gestion === */
// Ajout ou mise à jour d'un cours.
if(isset($_POST['add_event']) || isset($_POST['update_event'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);

    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $form = new Planning\FormEvent($bdd, $data);
    $errors = $form->checkEvent();

	if(empty($errors)) {
    	if(isset($_POST['add_event'])) $form->insertEvent();
		if(isset($_POST['update_event'])) $form->updateEvent();
    }
    // Si il n'y a aucune erreurs, on ajout le cours.
    echo json_encode($errors);
    exit;
}

// Suppression d'un cours.
if(isset($_GET['removeEventID'])){
    $form = new Planning\FormEvent($bdd, $_GET);
    $form->deleteEvent($_GET['removeEventID']);
    header('Location: ./gestion');
}

/** === Requête de la page Admin === */
// Ajout ou suppression d'une salle
if(isset($_POST['add_room']) || isset($_POST['remove_room'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);

    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formRoom = new Planning\FormOthers($bdd, $data);

    if(isset($_POST['add_room'])) {
        $errorsRoom = $formRoom->checkAddRoom();
        if(empty($errorsRoom)) $formRoom->insertRoom();
    }

    if(isset($_POST['remove_room'])) {
        $errorsRoom = $formRoom->checkDeleteRoom();
        if(empty($errorsRoom)) $formRoom->deleteRoom();
    }
    echo json_encode($errorsRoom);
    exit;
}

// Ajout ou suppression d'une promotion
if(isset($_POST['add_promo']) || isset($_POST['remove_promo'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);

    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formPromo = new Planning\FormOthers($bdd, $data);

    if(isset($_POST['add_promo'])) {
        $errorsPromo = $formPromo->checkPromo();
        if(empty($errorsPromo)) $formPromo->insertPromo();
        echo json_encode($errorsPromo);
    }
    if(isset($_POST['remove_promo'])) {
        $formPromo->deletePromo();
        echo json_encode([]);
    }
    exit;
}

// Ajout ou mise à jour d'une matière.
if (isset($_POST['add_matter']) || isset($_POST['update_matter'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formMatter = new Planning\FormMatter($bdd, $data);
	$errorsMatter = $formMatter->checkMatter();
	
	if(empty($errorsMatter)) {
		if(isset($_POST['add_matter'])) $formMatter->insertMatter();
		if(isset($_POST['update_matter'])) $formMatter->updateMatter();
	}
	echo json_encode($errorsMatter);
    exit;
}

// Suppression d'une matière.
if(isset($_GET['removeMatterID'])){
    $form = new Planning\FormMatter($bdd, $_GET);
    $form->deleteMatter($_GET['removeMatterID']);
    header('Location: ./admin');
}

// Ajout ou suppression d'une association entre une matière et un enseignant.
if (isset($_POST['add_teachMatter']) || isset($_POST['remove_teachMatter'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);
    
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formLinkMatter = new Planning\FormMatter($bdd, $data);

    if(isset($_POST['add_teachMatter'])) {
        $errorsLinkMatter = $formLinkMatter->checkAddLinkMatter();
        if(empty($errorsLinkMatter)) $formLinkMatter->linkMatterAndTeacher();

    } else if(isset($_POST['remove_teachMatter'])) {
        $errorsLinkMatter = $formLinkMatter->checkRemoveLinkMatter();
        if(empty($errorsLinkMatter)) $formLinkMatter->unLinkMatterAndTeacher();
    }
    echo json_encode($errorsLinkMatter);
    exit;
}

// Ajout ou mise à jour d'un usager.
if(isset($_POST['add_user']) || isset($_POST['update_user'])){

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);
    
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formUser = new Planning\FormUser($bdd, $data);

	if(isset($_POST['add_user'])) {
		$errorsAddUser = $formUser->checkAddUser();
		if(empty($errorsAddUser)) $formUser->insertUser();
		// On renvoie le tableau d'erreurs en format json.
		echo json_encode($errorsAddUser);
	}
	if(isset($_POST['update_user'])) {
		$errorsUpUser = $formUser->checkUpdateUser();
		if(empty($errorsUpUser)) $formUser->updateUser();
		// On renvoie le tableau d'erreurs en format json.
		echo json_encode($errorsUpUser);
	}
    exit;
}

// Suppression d'un usager.
if(isset($_GET['removeUserID'])){
    $form = new Planning\FormUser($bdd, $_GET);
    $form->deleteUser($_GET['removeUserID']);
    header('Location: ./admin');
}

// Ajout ou suppression d'une association entre une matière et un usager.
if (isset($_POST['add_userPromo']) || isset($_POST['remove_userPromo'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);
    
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formLinkPromo = new Planning\FormUser($bdd, $data);

    if(isset($_POST['add_userPromo'])) {
        $errorsLinkPromo = $formLinkPromo->checkAddLinkPromo();
        if(empty($errorsLinkPromo)) $formLinkPromo->linkUserToPromo();

    } else if(isset($_POST['remove_userPromo'])) {
        $errorsLinkPromo = $formLinkPromo->checkRemoveLinkPromo();
        if(empty($errorsLinkPromo)) $formLinkPromo->unlinkUserToPromo();
    }
    
    echo json_encode($errorsLinkPromo);
    exit;
}
?>