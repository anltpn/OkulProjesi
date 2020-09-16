<?php require_once('header.php'); ?>
<?php
	$kat_id = $_GET["id"];
	$tekil_kat_sql = "SELECT * FROM kategoriler WHERE kategori_id='$kat_id'";
	$statement = $pdo->prepare($tekil_kat_sql);	
	$statement->execute();
	$tekil_kat = $statement->fetch(PDO::FETCH_OBJ);

    if($user->kullanici_rol == 1 || $user->kullanici_rol == 2) {
        if (isset ($_POST['kategori_ust'])) {
            $ust = $_POST['kategori_ust'];
            $ad = $_POST['kategori_ad'];
			
            $guncelle_sql = "UPDATE kategoriler SET kategori_ust='$ust', kategori_ad='$ad' WHERE kategori_id='$kat_id'";
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
					<h2 class="border-bottom"><i class="fas fa-edit"></i> Kategori Güncelle</h2>
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
							<input type="text" class="form-control form-control-lg" value="<?= $tekil_kat->kategori_ad; ?>" name="kategori_ad" placeholder="Kategorinin adini giriniz (örn: Spor)">
							<small class="form-text text-muted">Kategorinin adını giriniz.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-edit"></i> Kategori Güncelle</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?>