<?php 
// Connexion à la base de donnée.
try {
    $bdd = new PDO('sqlite:database.db');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>