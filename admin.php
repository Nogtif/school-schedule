<?php 
require_once('./config.php');
require_once('./src/Planning/FormOthers.php');
require_once('./src/Planning/FormMatter.php');
require_once('./src/Planning/FormUser.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}

// Redirection vers l'index si l'usager n'est pas un administrateur.
if($_SESSION['rang'] < 3) {
    header('Location: ./');
}

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

// Ajout d'une matière.
if (isset($_POST['add_matter'])) {

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);

    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formMatter = new Planning\FormMatter($bdd, $data);
    $errorsMatter = $formMatter->checkAddMatter();

    if(empty($errorsMatter)) $formMatter->insertMatter();

    echo json_encode($errorsMatter);
    exit;
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

// Suppression d'une matière.
if(isset($_GET['removeMatterID'])) {
    $form = new Planning\FormMatter($bdd, $_GET);
    $form->deleteMatter($_GET['removeMatterID']);
}

// Ajout d'une matière.
if (isset($_POST['add_user'])){

    // On récupère les données reçu en js.
    parse_str($_POST['post'], $data);
    
    // On crée et vérifie si il n'y a aucune erreur dans le formulaire.
    $formUser = new Planning\FormUser($bdd, $data);
    $errorsUser = $formUser->checkAddUser();

    if(empty($errorsUser)) $formUser->insertUser();

    // On renvoie le tableau d'erreurs en format json.
    echo json_encode($errorsUser);
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Administration : Université d'Artois">
    <meta property="og:type" content="website">
    <meta name="author" content="Carpentier Quentin & Krogulec Paul-Joseph">
    <!-- CSS -->
    <link type="text/css" rel="stylesheet" href="./assets/css/icons.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/bootstrap.min.css">
    <link type="text/css" rel="stylesheet" href="./assets/css/style.css">
</head>
<body>
    <!-- HEADER -->
    <?php require_once('./views/header.php') ?>

    <!-- PAGE -->
    <div class="container">
        <h4>Administration</h4>
        <p>Gestion divers</p>
        <div class="row">
            <div class="col-md-4">
                <div class="box-content">
                    <div class="content-title">Ajout/Suppression d'une salle</div>
                    <form method="POST" id="form_room">
                        <div class="alert" style="display:none"></div>
                        <div class="form-group" id="room">
                            <label for="room">Nom de la salle</label>
                            <input type="text" name="room" class="form-control">
                            <small class="invalid-feedback"></small>
                        </div>
                        <input type="submit" name="add_room" value="Ajouter" class="btn btn-success">
                        <input type="submit" name="delete_room" value="Supprimer" class="btn btn-danger" style="float:right">
                    </form>
                </div>
            </div>
            <div class="col-md-5">
                <div class="box-content">
                    <div class="content-title">Ajouter une promotion</div>
                    <form method="POST" id="form_addPromo">
                        <div class="alert" style="display:none"></div>
                        <div class="row">
                            <div class="form-group col-md-5" id="name_promo">
                                <label for="name_promo">Nom de la promotion</label>
                                <input type="text" name="name_promo" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>
                            <div class="form-group col-md-7">
                                <label for="depid">Département</label>
                                <select name="depid" class="form-control">
                                    <?php
                                    $sDeps = $bdd->query('SELECT * FROM Departements ORDER BY NomDepartement');
                                    while($aDep = $sDeps->fetch()) {
                                        echo '<option value="'.$aDep['DepartementID'].'">'.$aDep['NomDepartement'].'</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="add_promo" value="Ajouter" class="btn btn-success">
                    </form>
                </div>
            </div>
            <div class="col-md-3">
                <div class="box-content">
                    <div class="content-title">Supprimer une promotion</div>
                    <form method="POST" id="form_removePromo">
                        <div class="alert" style="display:none"></div>
                        <div class="form-group">
                            <label for="promo">Promotion</label>
                            <select name="promo" class="form-control">
                                <option value="0">Choisir...</option>
                                <?php
                                $sPromo = $bdd->query('SELECT * FROM Promotions ORDER BY PromotionID');
                                while($aPromo = $sPromo->fetch()) {
                                    echo '<option value="'.$aPromo['PromotionID'].'">'.$aPromo['NomPromotion'].'</option>';
                                } ?>
                            </select>
                        </div>
                        <input type="submit" name="remove_promo" value="Supprimer" class="btn btn-danger">                    
                    </form>
                </div>
            
            </div>
        </div>

        <p>Gestion des matières</p>

        <div class="row">
            <div class="col-md-4">
                <div class="box-content">
                    <div class="content-title">Ajouter une matière</div>
                    <form method="POST" id="form_matter">
                        <div class="alert" style="display:none"></div>
                        <div class="row">
                            <div class="col-md-8 form-group" id="name_matter">
                                <label for="room">Nom de la matière</label>
                                <input type="text" name="name_matter" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-4 form-group" id="color_matter">
                                <label for="room">Couleur</label>
                                <input type="color" name="color_matter" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="room">Nom de la promotion </label>
                                <select name="promo" class="form-control">
                                <?php 
                                    $sPromo = $bdd->query('SELECT * FROM Promotions '.$option.' ORDER BY PromotionID');
                                    while($aPromo = $sPromo->fetch()) {
                                        echo '<option value="'.$aPromo['PromotionID'].'"'. ((isset($_POST['promotion']) && $_POST['promotion'] == $aPromo['PromotionID']) ? ' selected' : '') .'>'.$aPromo['NomPromotion'].'</option>';
                                    } ?>    
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="add_matter" value="Ajouter" class="btn btn-success">
                    </form>
                </div>

                <div class="box-content">
                    <div class="content-title">Associer une matière et un enseignant</div>
                    <form method="POST" id="form_teachMatter">
                        <div class="alert" style="display:none"></div>
                        <div class="row">
                            <div class="col-md-12 form-group">
                                <label for="room">Nom de la matière</label>
                                <select name="matiere" class="form-control">
                                    <?php
                                    $option = '';
                                    if($_SESSION['rang'] == 2) {
                                        $option = 'INNER JOIN Enseigne ON Matieres.MatiereID = Enseigne.MatiereID AND UsagerID = "'.$_SESSION['id'].'"';   
                                    }
                                    $sMatieres = $bdd->query('SELECT * FROM Matieres '.$option. ' ORDER BY NomMatiere');
                                    while($aMatieres = $sMatieres->fetch()) {
                                        echo '<option value="'.$aMatieres['MatiereID'].'">'.$aMatieres['NomMatiere'].'</option>';
                                    } ?> 
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="room">Enseignant</label>
                                <select name="enseignant" class="form-control">
                                    <?php if($_SESSION['rang'] == 2) {
                                            $sql = 'AND UsagerID = "'.$_SESSION['id'].'"';
                                        } else {
                                            $sql = '';
                                        }
                                        $query = $bdd->query('SELECT * FROM Usagers WHERE RangID = 2 ' . $sql);
                                        while ($row = $query->fetch()){
                                            echo '<option value="' .$row['UsagerID'] .'">' . $row['Prenom'] . ' ' .  $row['Nom'] . '</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="add_teachMatter" value="Associer" class="btn btn-success">
                        <input type="submit" name="remove_teachMatter" value="Dissocier" class="btn btn-danger" style="float: right">
                    </form>
                </div>
            </div>
            
            <div class="col-md-8">
                <div class="box-content">
                    <?php 
                    $sMatter = $bdd->query('SELECT * FROM Matieres m INNER JOIN Promotions p ON m.PromotionID = p.PromotionID ORDER BY NomMatiere ASC');
                    while($aMatter = $sMatter->fetch()) { ?>
                        <div class="list-items d-flex flex-row align-items-center justify-content-between">
                            <div class="item-info">
                                <p class="nameM"><?= $aMatter['NomMatiere'] ?></p>
                            </div>

                            <div class="item-info">
                                <p class="promoM"><?= $aMatter['NomPromotion'] ?></p>
                            </div>

                            <div class="item-info">
                                <p class="colorM" style="background-color: <?= $aMatter['CouleurMatiere'] ?>"></p>
                            </div>
                            
                            
                            <a href="?removeMatterID=<?= $aMatter['MatiereID'] ?>" class="btn btn-danger"><i class="mdi mdi-close"></i></a>
                            
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>

        <p>Gestion des usagers</p>

        <div class="row">
            <div class="col-md-4">
                <div class="box-content">
                    <div class="content-title">Ajout d'un usager</div>
                    <form method="POST" id="form_user">
                        <div class="alert" style="display:none"></div>
                        <div class="row">    
                            <div class="form-group" id="userid">
                                <label for="room">Identifiant</label>
                                <input type="text" name="userid" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-6 form-group" id="lastname">
                                <label for="room">Nom</label>
                                <input type="text" name="lastname" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-6 form-group" id="firstname">
                                <label for="room">Prénom</label>
                                <input type="text" name="firstname" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-7 form-group" id="password">
                                <label for="room">Mot de passe</label>
                                <input type="password" name="password" class="form-control">
                                <small class="invalid-feedback"></small>
                            </div>

                            <div class="col-md-5 form-group">
                                <label for="room">Rang</label>
                                <select name="rank" class="form-control">
                                    <?php
                                    $query = $bdd->query('SELECT * FROM Rangs');
                                    while ($row = $query->fetch()){
                                        echo '<option value="' .$row['RangID'] .'">' . $row['NomRang'].'</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="add_user" value="Enregistrer cet usager" class="btn btn-success">
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <?php require_once('./views/footer.php') ?>

	<!-- JS -->
	<script type="text/javascript" src="./assets/js/jquery.min.js"></script>
    <script type="text/javascript" src="./assets/js/functions.js"></script>
</body>
</html>