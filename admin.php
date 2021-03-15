<!DOCTYPE html>
<?php 
require_once('./config.php');
require_once('./src/Planning/FormMatter.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}

// Redirection vers l'index si l'usager n'est pas un administrateur.
if($_SESSION['rang'] < 3) {
    header('Location: ./');
}

$uMatters = $bdd->prepare('SELECT * FROM Matieres WHERE MatiereID = :id');
$uMatters->execute(array(':id' => isset($_GET['matterID']) ? $_GET['matterID'] : ''));
$uMatter = $uMatters->fetch();

// Suppression d'une matière.
if(isset($_GET['removeMatterID'])) {
    $form = new Planning\FormMatter($bdd, $_GET);
    $form->deleteMatter($_GET['removeMatterID']);
}

$uUsers = $bdd->prepare('SELECT * FROM Usagers WHERE UsagerID = :id');
$uUsers->execute(array(':id' => isset($_GET['usagerID']) ? $_GET['usagerID'] : ''));
$uUser = $uUsers->fetch();
?>
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
                                        echo '<option value="'.$aDep['DepartementID'].'">'.htmlspecialchars($aDep['NomDepartement']).'</option>';
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
                                    echo '<option value="'.$aPromo['PromotionID'].'">'.htmlspecialchars($aPromo['NomPromotion']).'</option>';
                                } ?>
                            </select>
                        </div>
                        <input type="submit" name="remove_promo" value="Supprimer" class="btn btn-danger">                    
                    </form>
                </div>
            
            </div>
        </div>

        <p id="matter">Gestion des matières</p>

        <div class="row">
            <div class="col-md-5">
                <div class="box-content">
                    <?php if(empty($_GET['matterID'])) {?>
                        <div class="content-title">Ajouter une matière</div>
                        <form method="POST" id="form_addMatter">
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
                                            echo '<option value="'.$aPromo['PromotionID'].'">'.htmlspecialchars($aPromo['NomPromotion']).'</option>';
                                        } ?>    
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="add_matter" value="Ajouter" class="btn btn-success">
                        </form>
                    </div>
                <?php } else { ?>
                    <div class="content-title">Modification d'une matière</div>
                        <form method="POST" id="form_updateMatter">
                            <div class="alert" style="display:none"></div>
                            <div class="row">
                                <input type="hidden" name="id" value="<?= $uMatter['MatiereID'] ?>">
                                <div class="col-md-8 form-group" id="name_matter">
                                    <label for="room">Nom de la matière</label>
                                    <input type="text" name="name_matter" class="form-control" value="<?= htmlspecialchars($uMatter['NomMatiere']) ?>">
                                    <small class="invalid-feedback"></small>
                                </div>

                                <div class="col-md-4 form-group" id="color_matter">
                                    <label for="room">Couleur</label>
                                    <input type="color" name="color_matter" class="form-control" value="<?= htmlspecialchars($uMatter['CouleurMatiere']) ?>">
                                    <small class="invalid-feedback"></small>
                                </div>

                                <div class="col-md-12 form-group">
                                    <label for="room">Nom de la promotion </label>
                                    <select name="promo" class="form-control">
                                    <?php 
                                        $sPromo = $bdd->query('SELECT * FROM Promotions '.$option.' ORDER BY PromotionID');
                                        while($aPromo = $sPromo->fetch()) {
                                            echo '<option value="'.$aPromo['PromotionID'].'"'. (($uMatter['PromotionID'] == $aPromo['PromotionID']) ? ' selected' : '') .'>'.htmlspecialchars($aPromo['NomPromotion']).'</option>';
                                        } ?>    
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="update_matter" value="Modifier" class="btn btn-success">
                            <a href="./config.php?removeMatterID=<?= $uMatter['MatiereID'] ?>" class="btn btn-danger" style="float:right">Supprimer</a>
                        </form>
                    </div>
                <?php } ?>

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
                                        echo '<option value="'.$aMatieres['MatiereID'].'">'.htmlspecialchars($aMatieres['NomMatiere']).'</option>';
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
                                            echo '<option value="' .$row['UsagerID'] .'">' . htmlspecialchars($row['Prenom'] . ' ' .  $row['Nom']) . '</option>';
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
            <div class="col-md-7">
                <div class="box-content" id="list-matter">
                    <div class="select-data">
                        <?php 
                        $sMatter = $bdd->query('SELECT * FROM Matieres m INNER JOIN Promotions p ON m.PromotionID = p.PromotionID ORDER BY NomMatiere ASC');
                        while($aMatter = $sMatter->fetch()) { ?>
                            <div class="list-items d-flex flex-row align-items-center justify-content-between">
                                <div class="item-info">
                                    <div class="colorM" style="background-color: <?= $aMatter['CouleurMatiere'] ?>"></div>
                                    <p class="nameM"><?= htmlspecialchars($aMatter['NomMatiere']) ?></p>
                                </div>

                                <div class="item-info">
                                    <p class="promoM"><?= htmlspecialchars($aMatter['NomPromotion']) ?></p>
                                </div>
                                <a href="?matterID=<?= $aMatter['MatiereID'] ?>#matter" class="btn btn-primary"><i class="mdi mdi-pencil-outline"></i></a>                                
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <p id="user">Gestion des usagers</p>

        <div class="row">
            <div class="col-md-5">
                <div class="box-content">
                    <?php if(empty($_GET['usagerID'])) { ?>
                        <div class="content-title">Ajout d'un usager</div>
                        <form method="POST" id="form_addUser">
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
                                            echo '<option value="' .$row['RangID'] .'">' . htmlspecialchars($row['NomRang']).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="add_user" value="Enregistrer cet usager" class="btn btn-success">
                        </form>
                    <?php } else { ?>
                        <div class="content-title">Modification d'un usager</div>
                        <form method="POST" id="form_updateUser">
                            <div class="alert" style="display:none"></div>
                            <div class="row">    
                                <div class="form-group" id="userid">
                                    <label for="room">Identifiant</label>
                                    <input type="text" name="userid" class="form-control" value="<?= htmlspecialchars($uUser['UsagerID']) ?>" readonly>
                                    <small class="invalid-feedback"></small>
                                </div>

                                <div class="col-md-6 form-group" id="lastname">
                                    <label for="room">Nom</label>
                                    <input type="text" name="lastname" class="form-control" value="<?= htmlspecialchars($uUser['Nom']) ?>">
                                    <small class="invalid-feedback"></small>
                                </div>

                                <div class="col-md-6 form-group" id="firstname">
                                    <label for="room">Prénom</label>
                                    <input type="text" name="firstname" class="form-control" value="<?= htmlspecialchars($uUser['Prenom']) ?>">
                                    <small class="invalid-feedback"></small>
                                </div>

                                <div class="form-group">
                                    <label for="room">Rang</label>
                                    <select name="rank" class="form-control">
                                        <?php
                                        $sRank = $bdd->query('SELECT * FROM Rangs');
                                        while ($aRank = $sRank->fetch()) {
                                            echo '<option value="' .$aRank['RangID'] .'"'.(($uUser['RangID'] == $aRank['RangID']) ? ' selected' : '') .'>'.htmlspecialchars($aRank['NomRang']).'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="update_user" value="Modifier" class="btn btn-success">
                            <a href="./config.php?removeUserID=<?= $uUser['UsagerID'] ?>" class="btn btn-danger" style="float:right">Supprimer</a>
                        </form>
                    <?php } ?>
                </div>

                <div class="box-content">
                    <div class="content-title">Associer un usager à une promotion</div>
                    <form method="POST" id="form_userPromo">
                        <div class="alert" style="display:none"></div>
                        <div class="row">
                            <div class="form-group">
                                <label for="userid">Etudiant</label>
                                <select name="userid" class="form-control">
                                    <?php
                                    $query = $bdd->query('SELECT * FROM Usagers WHERE RangID < 3');
                                    while ($row = $query->fetch()) {
                                        echo '<option value="' .$row['UsagerID'] .'">'.htmlspecialchars($row['Prenom']. ' ' .$row['Nom']).'</option>';
                                    }
                                    ?>
                                </select>
                            </div>

                            <div class="col-md-12 form-group">
                                <label for="promo">Promotion</label>
                                <select name="promo" class="form-control">
                                    <?php
                                    $sPromo = $bdd->query('SELECT * FROM Promotions ORDER BY NomPromotion');
                                    while($aPromo = $sPromo->fetch()) {
                                        echo '<option value="'.$aPromo['PromotionID'].'">'.htmlspecialchars($aPromo['NomPromotion']).'</option>';
                                    } ?> 
                                </select>
                            </div>
                        </div>
                        <input type="submit" name="add_userPromo" value="Associer" class="btn btn-success">
                        <input type="submit" name="remove_userPromo" value="Dissocier" class="btn btn-danger" style="float: right">
                    </form>
                </div>
            </div>
            <div class="col-md-7">
                <div class="box-content" id="list-users">
                    <div class="select-data">
                        <?php 
                        $sUsers = $bdd->query('SELECT * FROM Usagers INNER JOIN Rangs USING(RangID) ORDER BY Nom ASC');
                        while($aUsers = $sUsers->fetch()) { ?>
                            <div class="list-items d-flex flex-row align-items-center justify-content-between">
                                <div class="item-info">
                                    <p class="nameM"><?= htmlspecialchars($aUsers['Nom'] . ' '. $aUsers['Prenom']) ?></p>
                                    <span><?= $aUsers['UsagerID'] ?></span>
                                </div>

                                <div class="item-info">
                                    <p class="promoM"><?= htmlspecialchars($aUsers['NomRang']) ?></p>
                                </div>                               
                                <a href="?usagerID=<?= $aUsers['UsagerID'] ?>#user" class="btn btn-primary"><i class="mdi mdi-pencil-outline"></i></a>
                            </div>
                        <?php } ?>
                    </div>
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