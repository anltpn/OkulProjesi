<?php require_once('header.php'); ?>
<?php
	$item_id = $_GET["id"];
	$tekil_urun_sql = "SELECT * FROM urunler WHERE urun_id='$item_id'";
	$statement = $pdo->prepare($tekil_urun_sql);	
	$statement->execute();
	$tekil_urun = $statement->fetch(PDO::FETCH_OBJ);
	
    if($user->kullanici_rol == 1 || $user->kullanici_rol == 2) {
        if (isset ($_POST['urun_ad'])) {
            $ad = $_POST['urun_ad'];
            $kod = $_POST['urun_kod'];
            $kategori = $_POST['urun_kategori'];
            $fiyat = $_POST['urun_fiyat'];

            $guncelle_sql = "UPDATE urunler SET urun_ad='$ad', urun_kod='$kod', urun_kategori='$kategori', urun_fiyat='$fiyat' WHERE urun_id='$item_id'";
            $statement = $pdo->prepare($guncelle_sql);
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
					<h2 class="border-bottom"><i class="fas fa-edit"></i> Ürün Güncelle</h2>
					<form method="POST">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" value="<?= $tekil_urun->urun_ad; ?>" name="urun_ad" placeholder="Ürün ismi (örn: Restoran Takip Programı)">
							<small class="form-text text-muted">Ürünün tam adını giriniz.</small>
						</div>
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" value="<?= $tekil_urun->urun_kod; ?>" name="urun_kod" placeholder="Ürün stok kodu (örn: AJDHF56)">
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
							<input type="text" class="form-control form-control-lg" value="<?= $tekil_urun->urun_fiyat; ?>" name="urun_fiyat" placeholder="Ürün fiyatı (örn: 1150)">
							<small class="form-text text-muted">Ürünün TL cinsinden fiyatını giriniz.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Ürün Güncelle</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?>