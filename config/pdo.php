<?php 
// Connexion à la base de donnée.
try {
    $bdd = new PDO('sqlite:'.__DIR__.'/database.db');
} catch (Exception $e) {
    die('Erreur : ' . $e->getMessage());
}
?>