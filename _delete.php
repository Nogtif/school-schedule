<?php 
require_once('./config.php');
require_once('./src/Planning/FormEvent.php');

if(isset($_GET['CourID'])){
    $form = new Planning\FormEvent($bdd, $_GET);
    $form->deleteEvent($_GET['CourID']);
    header('Location: ./gestion');
}
?>