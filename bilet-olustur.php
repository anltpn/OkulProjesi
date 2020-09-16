<?php ob_start(); ?><?php require_once('header.php'); ?>
<?php
    if (isset ($_POST['bilet_baslik'])) {
        $baslik = $_POST['bilet_baslik'];
        $icerik = $_POST['bilet_icerik'];
        $sahip = $user->kullanici_id;
	
        $ekle_sql = "INSERT INTO biletler (bilet_id, bilet_baslik, bilet_icerik, bilet_sahip) VALUES (NULL, '$baslik', '$icerik', '$sahip')";
        $statement = $pdo->prepare($ekle_sql);
        $statement->execute();
		//print_r($statement->errorInfo());
		header('Location: index.php');
		exit;
    }
?>
	<div class="container mt-5">
		<div class="row">
			<div class="col-12">
				<div class="blok bg-white border rounded shadow-sm p-3">
					<h2 class="border-bottom"><i class="fas fa-plus"></i> Bilet Oluştur</h2>
					<form method="POST">
						<div class="form-group">
							<input type="text" class="form-control form-control-lg" name="bilet_baslik" placeholder="Başlık (örn: Facebook programı hakkında destek istiyorum)">
							<small class="form-text text-muted">Destek biletinizin başlığını giriniz.</small>
						</div>
						<div class="form-group">
							<textarea class="form-control" name="bilet_icerik" rows="5"></textarea>
							<small class="form-text text-muted">Destek almak istediğiniz konuyu ayrıntısı ile yazınız.</small>
						</div>
						<button type="submit" class="btn btn-success"><i class="fas fa-plus"></i> Bilet Oluştur</button>
					</form>
				</div>
			</div>
		</div>
	</div>
<?php require_once('footer.php'); ?><?php ob_end_flush(); ?>