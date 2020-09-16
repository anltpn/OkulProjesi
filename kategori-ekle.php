<?php ob_start(); ?>
<?php require_once('header.php'); ?>
<?php
    if($user->kullanici_rol == 1 || $user->kullanici_rol == 2) {
        if (isset ($_POST['kategori_ust'])) {
            $ust = $_POST['kategori_ust'];
            $ad = $_POST['kategori_ad'];
			
            $ekle_sql = "INSERT INTO kategoriler (kategori_id, kategori_ust, kategori_ad) VALUES (NULL, '$ust', '$ad')";
            $statement = $pdo->prepare($ekle_sql);
            $statement->execute();
			
			header('Location: index.php');
			exit;
        }
    } else {
		header('Location: index.php');
		exit;
    }	
?>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<div class="blok bg-white border rounded shadow-sm p-3">
					<h2 class="border-bottom"><i class="fas fa-plus"></i> Kategori Ekle</h2>
					<form method="POST">
						<div class="form-group">
							<select class="form-control form-control-lg" name="kategori_ust">
								<?php
									$kategoriler_sql = "SELECT * FROM kategoriler";
									$statement = $pdo->prepare($kategoriler_sql);	
									$statement->execute();
									$kategoriler = $statement->fetchAll(PDO::FETCH_OBJ);
								?>
								<option value="0" selected>YOK</option>
								<?php foreach($kategoriler as $kategori): ?>
									<option value="<?= $kategori->kategori_id; ?>"><?= $kategori->kategori_ad; ?></option>
								<?php endforeach; ?>
							</select>
							<small class="form-text text-muted">Kategorinin üst kategorisini seçiniz.</small>
						</div>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" name="kategori_ad" placeholder="Kategorinin adını giriniz (örn: Spor)">
							<small class="form-text text-muted">Kategorinin adını giriniz.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Kategori Ekle</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?>
<?php ob_end_flush(); ?>