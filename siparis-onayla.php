<?php
	require_once 'db.php';
	
	$islem_id = $_GET["id"];
	$guncelle_sql = "UPDATE siparisler SET siparis_durum='1' WHERE siparis_id='$islem_id'";
    $statement = $pdo->prepare($guncelle_sql);
    $statement->execute();
	
	header("Location: index.php");
	exit;
?>