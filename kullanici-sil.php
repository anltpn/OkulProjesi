<?php
	require_once 'db.php';
	
	$islem_id = $_GET["id"];
	$sil_sql = "DELETE FROM kullanicilar WHERE kullanici_id='$islem_id'";				
	$statement = $pdo->prepare($sil_sql);				
	$statement->execute();
	
	header("Location: index.php");
	exit;
?>