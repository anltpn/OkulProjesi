<?php
    $urunler_sql = "SELECT * FROM urunler";
	$statement = $pdo->prepare($urunler_sql);	
	$statement->execute();
	$urunler = $statement->fetchAll(PDO::FETCH_OBJ);
	
	$kategoriler_sql = "SELECT * FROM kategoriler";
	$statement = $pdo->prepare($kategoriler_sql);	
	$statement->execute();
	$kategoriler = $statement->fetchAll(PDO::FETCH_OBJ);
	
	$kullanicilar_sql = "SELECT kullanici_id, kullanici_ad, kullanici_mail, kullanici_rol FROM kullanicilar";
	$statement = $pdo->prepare($kullanicilar_sql);	
	$statement->execute();
	$kullanicilar = $statement->fetchAll(PDO::FETCH_OBJ);
?>

<div class="container mt-5">
	<div class="row">
		<div class="col-12">
			<div class="blok bg-white border rounded shadow-sm p-3">
				<h2 class="border-bottom"><i class="fas fa-list"></i> Ürün Listesi</h2>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Ürün ID</th>
								<th><i class="fas fa-cubes"></i> Ürün Kodu</th>
								<th scope="col"><i class="fas fa-tag"></i> Ürün Adı</th>
								<th scope="col"><i class="fas fa-folder"></i> Ürün Kategorisi</th>
								<th class="text-center" scope="col"><i class="fas fa-lira-sign"></i> Ürün Fiyatı</th>
								<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($urunler as $urun): ?>
								<tr>
									<th class="align-middle text-center" scope="row"><?= $urun->urun_id; ?></th>
									<th class="align-middle"><?= $urun->urun_kod; ?></th>
									<td class="align-middle"><?= $urun->urun_ad; ?></td>
									<?php
										$kategori_sql = "SELECT * FROM kategoriler WHERE kategori_id=:id";
										$statement = $pdo->prepare($kategori_sql);
										$statement->execute([':id' => $urun->urun_kategori]);
										$kategori = $statement->fetch(PDO::FETCH_OBJ);
									?>
									<td class="align-middle"><?= $kategori->kategori_ad; ?></td>
									<td class="text-center align-middle text-success"><strong><?= $urun->urun_fiyat; ?> ₺</strong></td>
									<td class="text-center align-middle"><a class="text-info font-weight-bold" href="#">Düzenle</a> | <a class="text-danger font-weight-bold" href="#">Sil</a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12">
			<div class="blok bg-white border rounded shadow-sm p-3">
				<h2 class="border-bottom"><i class="fas fa-list"></i> Kategori Listesi</h2>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Kategori ID</th>
								<th><i class="fas fa-tag"></i> Kategori Adı</th>
								<th><i class="fas fa-folder"></i> Üst Kategori Adı</th>
								<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($kategoriler as $kategori): ?>
								<tr>
									<th class="align-middle text-center" scope="row"><?= $kategori->kategori_id; ?></th>
									<th class="align-middle"><?= $kategori->kategori_ad; ?></th>
									<?php
										$ust_kategori_sql = "SELECT * FROM kategoriler WHERE kategori_ust=:id";
										$statement = $pdo->prepare($ust_kategori_sql);
										$statement->execute([':id' => $kategori->kategori_ust]);
										$ust_kategori = $statement->fetch(PDO::FETCH_OBJ);
									?>
									<?php if($ust_kategori->kategori_ust == 0) {?>
										<td class="align-middle text-center">YOK</td>
									<?php } else { ?>
										<td class="align-middle"><?= $ust_kategori->kategori_ad; ?></td>
									<?php } ?>									
									<td class="text-center align-middle"><a class="text-info font-weight-bold" href="#">Düzenle</a> | <a class="text-danger font-weight-bold" href="#">Sil</a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="row mt-5">
		<div class="col-12">
			<div class="blok bg-white border rounded shadow-sm p-3">
				<h2 class="border-bottom"><i class="fas fa-list"></i> Kullanıcı Listesi</h2>
				<div class="table-responsive">
					<table class="table table-hover table-striped table-bordered">
						<thead>
							<tr>
								<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Kullanıcı ID</th>
								<th><i class="fas fa-tag"></i> Kullanıcı Adı</th>
								<th><i class="fas fa-envelope"></i> Kullanıcı E-Postası</th>
								<th class="text-center"><i class="fas fa-at"></i> Kullanıcı Rolü</th>
								<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($kullanicilar as $kullanici): ?>
								<tr>
									<th class="align-middle text-center" scope="row"><?= $kullanici->kullanici_id; ?></th>
									<th class="align-middle"><?= $kullanici->kullanici_ad; ?></th>								
									<th class="align-middle"><?= $kullanici->kullanici_mail; ?></th>
									<?php
										if($kullanici->kullanici_rol == 0) {
											echo '<th class="align-middle text-center"><span class="badge badge-primary ml-2 align-middle">Müşteri</span></th>';
										} else if ($kullanici->kullanici_rol == 1) {
											echo '<th class="align-middle text-center"><span class="badge badge-danger ml-2 align-middle">Yönetici</span></th>';
										} else {
											echo '<th class="align-middle text-center"><span class="badge badge-warning ml-2 align-middle">Editör</span></th>';
										}
									?>						
									<td class="text-center align-middle"><a class="text-danger font-weight-bold" href="#">Sil</a></td>
								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
