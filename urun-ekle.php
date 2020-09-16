<?php ob_start(); ?><?php require_once('header.php'); ?>
<?php
    if($user->kullanici_rol == 1 || $user->kullanici_rol == 2) {
        if (isset ($_POST['urun_ad'])) {
            $ad = $_POST['urun_ad'];
            $kod = $_POST['urun_kod'];
            $kategori = $_POST['urun_kategori'];
            $fiyat = $_POST['urun_fiyat'];
			
            $ekle_sql = "INSERT INTO urunler (urun_id, urun_ad, urun_kod, urun_kategori, urun_fiyat) VALUES (NULL, '$ad', '$kod', '$kategori', '$fiyat')";
            $statement = $pdo->prepare($ekle_sql);
            $statement->execute();
			//print_r($statement->errorInfo());
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
					<h2 class="border-bottom"><i class="fas fa-plus"></i> Ürün Ekle</h2>
					<form method="POST">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" name="urun_ad" placeholder="Ürün ismi (örn: Instagram Bot Programı)">
							<small class="form-text text-muted">Ürünün tam adını giriniz.</small>
						</div>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" name="urun_kod" placeholder="Ürün stok kodu (örn: AJDHF56)">
							<small class="form-text text-muted">Ürünün stok kodunu giriniz.</small>
						</div>
						<div class="form-group">
							<select class="form-control form-control-lg" name="urun_kategori">
								<?php
									$kategoriler_sql = "SELECT * FROM kategoriler";
									$statement = $pdo->prepare($kategoriler_sql);	
									$statement->execute();
									$kategoriler = $statement->fetchAll(PDO::FETCH_OBJ);
								?>
								<option value="0" selected>Ürün kategorisini seçiniz...</option>
								<?php foreach($kategoriler as $kategori): ?>
									<option value="<?= $kategori->kategori_id; ?>"><?= $kategori->kategori_ad; ?></option>
								<?php endforeach; ?>
							</select>
							<small class="form-text text-muted">Ürünün kategorisini seçiniz.</small>
						</div>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" name="urun_fiyat" placeholder="Ürün fiyatı (örn: 1150)">
							<small class="form-text text-muted">Ürünün TL cinsinden fiyatını giriniz.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Ürün Ekle</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?><?php ob_end_flush(); ?>