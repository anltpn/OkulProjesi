<?php
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'ogutcuyazilim_siteuser');
	define('DB_PASSWORD', 'PpD8]poAmf$8');
	define('DB_NAME', 'ogutcuyazilim_site');
	
	try {
		$pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
		$pdo->query("SET NAMES utf8");
	} catch(PDOException $e) {
		die("Veritabaniyla baglanti saglanamadi: " . $e->getMessage());
	}
 ?>