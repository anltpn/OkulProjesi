<?php
	session_start();
	
	require_once 'db.php';
	
	if(!isset($_SESSION['email']) || empty($_SESSION['email'])){
		header('Location: giris.php');
		exit;
	}
	
	$kullanici = $_SESSION['id'];
	$user_sql = "SELECT * FROM kullanicilar WHERE kullanici_id=:id";
	$statement = $pdo->prepare($user_sql);
	$statement->execute([':id' => $kullanici]);
	$user = $statement->fetch(PDO::FETCH_OBJ);	
?>

<!doctype html>
<html lang="tr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link href="https://fonts.googleapis.com/css2?family=Rajdhani:wght@400;500;700&display=auto" rel="stylesheet">
		<script src="https://kit.fontawesome.com/ce03877bf7.js" crossorigin="anonymous"></script>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link href="assets/favicon.ico" rel="icon" type="image/x-icon" />
		<link rel="stylesheet" href="assets/style.css">
		<title>Öğütçü Yazılım | Panel</title>
	</head>
	<body class="bg-light">
	
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
			
			</div>
		</div>
	</div>
	
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
			<a class="navbar-brand" href="index.php"><strong>{öğütçü</strong>yazılım}</a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Menü">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarText">
				<ul class="navbar-nav mr-auto">
					<?php if ($user->kullanici_rol == 1 || $user->kullanici_rol == 2) { ?>
						<li class="nav-item">
							<a class="nav-link" href="urun-ekle.php"><i class="fas fa-plus"></i> Ürün Ekle</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="kategori-ekle.php"><i class="fas fa-plus"></i> Kategori Ekle</a>
						</li>
					<?php } ?>
					
					<?php if ($user->kullanici_rol == 0) { ?>
						<li class="nav-item">
							<a class="nav-link" href="bilet-olustur.php"><i class="fas fa-plus"></i> Destek Bileti Oluştur</a>
						</li>
					<?php } ?>
				</ul>
				<span class="navbar-text">
					<?php
						if($user->kullanici_rol == 0) {
							echo '<span class="badge badge-primary ml-2 align-middle">Müşteri</span>';
						} else if ($user->kullanici_rol == 1) {
							echo '<span class="badge badge-danger ml-2 align-middle">Yönetici</span>';
						} else {
							echo '<span class="badge badge-warning ml-2 align-middle">Editör</span>';
						}
					?>
					<strong>Hoşgeldiniz,</strong> <?= $user->kullanici_ad; ?> | <a class="text-danger font-weight-bold" href="cikis.php">Çıkış</a>
				</span>
			</div>
		</nav>