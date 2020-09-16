<?php ob_start(); ?><?php require_once('header.php'); ?>
<?php
	$item_id = $_GET["id"];
	$tekil_bilet_sql = "SELECT * FROM biletler WHERE bilet_id='$item_id'";
	$statement = $pdo->prepare($tekil_bilet_sql);	
	$statement->execute();
	$tekil_bilet = $statement->fetch(PDO::FETCH_OBJ);
	
	$bilet_kullanici = "SELECT kullanici_ad, kullanici_rol FROM kullanicilar WHERE kullanici_id='$tekil_bilet->bilet_sahip'";
	$statement = $pdo->prepare($bilet_kullanici);	
	$statement->execute();
	$bilet_kullanici = $statement->fetch(PDO::FETCH_OBJ);
	
    if (isset ($_POST['bilet_icerik'])) {
        $icerik = $_POST['bilet_icerik'];

        $ekle_sql = "INSERT INTO yanitlar (yanit_id, yanit_bilet, yanit_kullanici, yanit_icerik) VALUES (NULL, '$item_id', '$user->kullanici_id', '$icerik')";
        $statement = $pdo->prepare($ekle_sql);
        $statement->execute();
			
		header('Location: index.php');
		exit;
    }	
?>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<div class="blok bg-white border rounded shadow-sm p-3">
					<h2 class="border-bottom"><i class="fas fa-ticket-alt"></i> Bilet Görüntüle</h2>
					<p><?= $tekil_bilet->bilet_icerik; ?></p>
					<div class="border-top pt-2 text-right">
						<i class="fas fa-user"></i> <?= $bilet_kullanici->kullanici_ad; ?>
						<?php
							if($bilet_kullanici->kullanici_rol == 0) {
								echo '<span class="badge badge-primary ml-2 align-middle">Müşteri</span>';
							} else if ($bilet_kullanici->kullanici_rol == 1) {
								echo '<span class="badge badge-danger ml-2 align-middle">Yönetici</span>';
							} else {
								echo '<span class="badge badge-warning ml-2 align-middle">Editör</span>';
							}
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="row mt-5">
			<div class="col-12">
				<div class="blok bg-white border rounded shadow-sm p-3">
					<h2 class="border-bottom"><i class="fas fa-comment-dots"></i> Yanıtlar</h2>
					<?php
						$yanitlar_sql = "SELECT * FROM yanitlar WHERE yanit_bilet='$tekil_bilet->bilet_id'";
						$statement = $pdo->prepare($yanitlar_sql);	
						$statement->execute();
						$yanitlar = $statement->fetchAll(PDO::FETCH_OBJ);
					?>
					<?php foreach($yanitlar as $yanit): ?>
						<div class="bg-light border rounded shadow-sm mt-3 p-3">
							<p><?= $yanit->yanit_icerik; ?></p>
					<div class="border-top pt-2 text-right">
						<?php
							$yanit_kullanici_sql = "SELECT kullanici_ad, kullanici_rol FROM kullanicilar WHERE kullanici_id='$yanit->yanit_kullanici'";
							$statement = $pdo->prepare($yanit_kullanici_sql);	
							$statement->execute();
							$yanit_kullanici = $statement->fetch(PDO::FETCH_OBJ);
						?>
						<i class="fas fa-user"></i> <?= $yanit_kullanici->kullanici_ad; ?>
						<?php
							if($yanit_kullanici->kullanici_rol == 0) {
								echo '<span class="badge badge-primary ml-2 align-middle">Müşteri</span>';
							} else if ($yanit_kullanici->kullanici_rol == 1) {
								echo '<span class="badge badge-danger ml-2 align-middle">Yönetici</span>';
							} else {
								echo '<span class="badge badge-warning ml-2 align-middle">Editör</span>';
							}
						?>
					</div>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="row my-5">
			<div class="col-12">
				<div class="blok bg-white border rounded shadow-sm p-3">
					<h2 class="border-bottom"><i class="fas fa-plus"></i> Yanıt Ekle</h2>
					<form method="POST">
						<div class="form-group">
							<textarea class="form-control" name="bilet_icerik" rows="5"></textarea>
							<small class="form-text text-muted">Destek bileti ile ilgili yanıtınızı giriniz.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Yenıt Ekle</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?><?php ob_end_flush(); ?>