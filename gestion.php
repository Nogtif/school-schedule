<!DOCTYPE html>
<?php 
require_once('./config.php');

// Redirection vers le login si l'usager n'est pas connecté.
if(!isOnline()) {
    header('Location: ./login');
}
// Redirection vers l'index si l'usager n'est ni un enseignant, ni un administrateur.
if($_SESSION['rang'] < 2) {
    header('Location: ./');
}

$uEvents = $bdd->prepare('SELECT * FROM Cours WHERE CourID = :id');
$uEvents->execute(array(':id' => isset($_GET['courID']) ? $_GET['courID'] : ''));
$uEvent = $uEvents->fetch();
?>
<html lang="fr-FR">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gerer mes cours : Université d'Artois</title>
    <link type="image/x-icon" rel="shortcut icon" href="./assets/img/favicon.ico"/>
    <meta property="og:title" content="Gerer mes cours : Université d'Artois">
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
        <h4>Gestion des cours</h4>
        <div class="row">
            <div class="col-md-5">
                <div class="box-content getEvent">
                    <?php if(empty($_GET['courID'])) {?>
                        <div class="content-title">Ajouter un cours</div>
                        <form method="POST" id="form_addEvent">
                            <div class="alert" style="display:none"></div>
                            <div class="row">
                                <div class="form-group">
                                    <label for="matter">Matière</label>
                                    <select name="matter" id="" class="form-control">
                                        <?php
                                        $option = ($_SESSION['rang'] == 2) ? 'INNER JOIN Enseigne ON Matieres.MatiereID = Enseigne.MatiereID AND UsagerID = "'.$_SESSION['id'].'"' : '';
                                        $sMatieres = $bdd->query('SELECT * FROM Matieres '.$option. ' ORDER BY NomMatiere');
                                        while($aMatieres = $sMatieres->fetch()) {
                                            echo '<option value="'.$aMatieres['MatiereID'].'">'.htmlspecialchars($aMatieres['NomMatiere']).'</option>';
                                        } ?> 
                                    </select>
                                </div>
                                <div class="col-md-7 form-group" id="firstdate">
                                    <label for="firstdate">Date</label>
                                    <input type="date" name="firstdate" class="form-control">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-5 form-group" id="nbweek">
                                    <label for="nbweek">Nombre de semaine</label>
                                    <input type="number" name="nbweek" class="form-control" value="1">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-6 form-group" id="start">
                                    <label for="start">Heure de début</label>
                                    <input type="time" name="start" class="form-control">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-6 form-group" id="end">
                                    <label for="end">Heure de fin</label>
                                    <input type="time" name="end" class="form-control">
                                    <small class="invalid-feedback"></small>  
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="type">Type de cours</label>
                                    <select name="type" class="form-control">
                                        <?php $query = $bdd->query('SELECT * FROM TypeCours');
                                            while ($row = $query->fetch()){
                                                echo '<option value="' . $row['TypeID'].'">' . htmlspecialchars($row['NomType']) . '</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="user">Enseignant</label>
                                    <select name="user" class="form-control">
                                        <?php $sql = ($_SESSION['rang'] == 2) ? 'AND UsagerID = "'.$_SESSION['id'].'"' : '';
                                            $query = $bdd->query('SELECT * FROM Usagers WHERE RangID = 2 ' . $sql);
                                            while ($row = $query->fetch()){
                                                echo '<option value="' .$row['UsagerID'] .'">'.htmlspecialchars($row['Prenom'].' '.$row['Nom']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="room">Salle</label>
                                    <select name="room" class="form-control">
                                        <?php $query = $bdd->query('SELECT * FROM Salles');
                                            while ($row = $query->fetch()){
                                                echo '<option value="'.$row['SalleID'].'">'.htmlspecialchars($row['NomSalle']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="add_event" value="Programmer ce cours" class="btn btn-success">
                        </form>
                    <?php } else { ?>
                        <div class="content-title">Modification d'un cours</div>
                        <form method="POST" id="form_updateEvent">
                            <div class="alert" style="display:none"></div>
                            <div class="row">
                                <input type="hidden" name="id" value="<?php echo $uEvent['CourID'] ?>">
                                <div class="form-group">
                                    <label for="matter">Matière</label>
                                    <select name="matter" id="" class="form-control">
                                        <?php
                                        $option = ($_SESSION['rang'] == 2) ? $option = 'INNER JOIN Enseigne ON Matieres.MatiereID = Enseigne.MatiereID AND UsagerID = "'.$_SESSION['id'].'"' : '';
                                        $sMatieres = $bdd->query('SELECT * FROM Matieres '.$option. ' ORDER BY NomMatiere');
                                        while($row = $sMatieres->fetch()) {
                                            echo '<option value="'.$row['MatiereID'].'"'.($uEvent['MatiereID'] == $row['MatiereID'] ? ' selected' : '').'>'.htmlspecialchars($row['NomMatiere']).'</option>';
                                        } ?> 
                                    </select>
                                </div>
                                <div class="col-md-7 form-group" id="firstdate">
                                    <label for="firstdate">Date</label>
                                    <input type="date" name="firstdate" class="form-control" value="<?php echo date('Y-m-d', $uEvent['DateDebut']) ?>">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-5 form-group" id="nbweek">
                                    <label for="nbweek">Date</label>
                                    <input type="number" name="nbweek" class="form-control" value="<?php echo $uEvent['NbSemaines'] ?>">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-6 form-group" id="start">
                                    <label for="start">Heure de début</label>
                                    <input type="time" name="start" class="form-control" value="<?php echo $uEvent['HeureDebut'] ?>">
                                    <small class="invalid-feedback"></small>
                                </div>
                                <div class="col-md-6 form-group" id="end">
                                    <label for="end">Heure de fin</label>
                                    <input type="time" name="end" class="form-control" value="<?php echo $uEvent['HeureFin'] ?>">
                                    <small class="invalid-feedback"></small>  
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="type">Type de cours</label>
                                    <select name="type" class="form-control">
                                        <?php $query = $bdd->query('SELECT * FROM TypeCours');
                                            while ($row = $query->fetch()){
                                                echo '<option value="'.$row['TypeID'].'"'.($uEvent['TypeID'] == $row['TypeID'] ? ' selected' : '').'>'.htmlspecialchars($row['NomType']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label for="user">Enseignant</label>
                                    <select name="user" class="form-control">
                                        <?php $sql = ($_SESSION['rang'] == 2) ? 'AND UsagerID = "'.$_SESSION['id'].'"' : '';
                                            $query = $bdd->query('SELECT * FROM Usagers WHERE RangID = 2 ' . $sql);
                                            while ($row = $query->fetch()){
                                                echo '<option value="'.$row['UsagerID'].'"'.($uEvent['UsagerID'] == $row['UsagerID'] ? ' selected' : '').'>'.htmlspecialchars($row['Prenom'].' '.$row['Nom']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-md-3 form-group">
                                    <label for="room">Salle</label>
                                    <select name="room" class="form-control">
                                        <?php $query = $bdd->query('SELECT * FROM Salles');
                                            while ($row = $query->fetch()){
                                                echo '<option value="'.$row['SalleID'].'"'.($uEvent['SalleID'] == $row['SalleID'] ? ' selected' : '').'>'.htmlspecialchars($row['NomSalle']).'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <input type="submit" name="update_event" value="Modifier ce cours" class="btn btn-success">
                            <a href="?removeEventID=<?php echo $uEvent['CourID'] ?>" class="btn btn-danger" style="float:right">Supprimer ce cour</a>
                        </form>
                    <?php } ?>
                </div>
            </div>

            <div class="col-md-7"> 
                <div class="box-content" id="list-event">
                    <div class="select-data">
                        <?php 
                        $where = ($_SESSION['rang'] == 2) ? 'WHERE UsagerID ="'. $_SESSION['id'] . '"' : '';
                        $sCours = $bdd->query('SELECT * FROM Cours INNER JOIN Matieres USING(MatiereID), TypeCours USING(TypeID), Usagers USING(UsagerID), Promotions USING(PromotionID), Salles USING(SalleID) '.$where.' ORDER BY DateDebut DESC, HeureDebut DESC');
                        while($aCours = $sCours->fetch()) { 
                            echo '<div class="list-items d-flex flex-row align-items-center justify-content-between">';
                            echo '<div class="item-info">';
                            echo '<p>'.$aCours['NomType'].' '.$aCours['NomMatiere'].'</p>';
                            echo '<span>Par '.htmlspecialchars($aCours['Prenom']). ' '.htmlspecialchars($aCours['Nom']). ', en '.htmlspecialchars($aCours['NomSalle']).'</span>';
                            echo '</div>';
                            echo '<div class="item-info">';
                            echo '<p>'.date('d-m-Y', $aCours['DateDebut']).' au '.date('d-m-Y', ($aCours['DateDebut'] + ($aCours['NbSemaines'] * 604800))).'</p>';
                            echo '<span>de '.$aCours['HeureDebut']. ' à '.$aCours['HeureFin'].'</span>';
                            echo '</div>';
                            echo '<a href="?courID='.$aCours['CourID'].'" class="btn btn-primary"><i class="mdi mdi-pencil-outline"></i></a>';
                            echo '</div>';
                        } ?>
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
