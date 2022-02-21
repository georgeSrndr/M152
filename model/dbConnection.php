<?php
require 'constantes.inc.php';

function facebookConnect() {
	static $db = NULL;
	try {
		if ($db == NULL) {
			$db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASSWORD, array (
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					PDO::ATTR_PERSISTENT => true,
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_EMULATE_PREPARES => false, 
					PDO::FETCH_ASSOC
			));
		}
	} catch (PDOException $e) {
		echo 'Erreur : ' . $e->getMessage() . '<br />';
		echo 'N° : ' . $e->getCode();
		// Quitte le script et meurt
		die('Could not connect to MySQL');
	}
	  // Pas d'erreur, retourne un connecteur
	return $db;
}
?>