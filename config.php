<?php 
session_start();

require_once('./config/pdo.php');
require_once('./config/site.php');

function isOnline() {
	if(isset($_SESSION['id'])) {
		return true;
	}
    return false;
}
?>