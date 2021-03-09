<?php 
session_start();
require_once(__DIR__.'/config/pdo.php');

function isOnline() {
	if(isset($_SESSION['id'])) {
		return true;
	}
    return false;
}
?>