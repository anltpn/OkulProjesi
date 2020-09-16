<?php require_once('header.php'); ?>

<?php
	$urunler_sql = "SELECT * FROM urunler";
	$statement = $pdo->prepare($urunler_sql);	
	$statement->execute();
	$urunler = $statement->fetchAll(PDO::FETCH_OBJ);
			
	$kategoriler_sql = "SELECT * FROM kategoriler";
	$statement = $pdo->prepare($kategoriler_sql);	
	$statement->execute();
	$kategoriler = $statement->fetchAll(PDO::FETCH_OBJ);
	
	$biletler_sql = "SELECT * FROM biletler";
	$statement = $pdo->prepare($biletler_sql);	
	$statement->execute();
	$biletler = $statement->fetchAll(PDO::FETCH_OBJ);
	
	$siparisler_sql = "SELECT * FROM siparisler WHERE siparis_durum=0";
	$statement = $pdo->prepare($siparisler_sql);
	$statement->execute();
	$siparisler = $statement->fetchAll(PDO::FETCH_OBJ);

	$kullanicilar_sql = "SELECT kullanici_id, kullanici_ad, kullanici_mail, kullanici_rol FROM kullanicilar";
	$statement = $pdo->prepare($kullanicilar_sql);	
	$statement->execute();
	$kullanicilar = $statement->fetchAll(PDO::FETCH_OBJ);
?>

	<?php if ($user->kullanici_rol == 1 || $user->kullanici_rol == 2) { ?>
		<div class="container mt-5">
			<div class="row my-5">
				<div class="col-12">
					<div class="blok bg-white border rounded shadow-sm p-3">
						<h2 class="border-bottom"><i class="fas fa-list"></i> Sipariş Listesi</h2>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Sipariş ID</th>
										<th><i class="fas fa-tag"></i> Ürün Adı</th>
										<th><i class="fas fa-user"></i> Sipariş Sahibi</th>
										<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($siparisler as $siparis): ?>
										<tr>
											<th class="align-middle text-center" scope="row"><?= $siparis->siparis_id; ?></th>
											<?php
												$urun_adi_sql = "SELECT urun_ad FROM urunler WHERE urun_id='$siparis->siparis_urun'";
												$statement = $pdo->prepare($urun_adi_sql);
												$statement->execute();
												$urun_adi = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $urun_adi->urun_ad; ?></td>
											<?php
												$kullanici_adi_sql = "SELECT kullanici_id, kullanici_ad FROM kullanicilar WHERE kullanici_id='$siparis->siparis_kullanici'";
												$statement = $pdo->prepare($kullanici_adi_sql);
												$statement->execute();
												$kullanici_adi = $statement->fetch(PDO::FETCH_OBJ);
											?>											
											<td class="align-middle"><?= $kullanici_adi->kullanici_ad; ?> (#<?= $kullanici_adi->kullanici_id; ?>)</td>
											<td class="text-center align-middle"><a class="text-success font-weight-bold" href="siparis-onayla.php?id=<?= $siparis->siparis_id; ?>">Onayla</a> | <a class="text-danger font-weight-bold" href="siparis-sil.php?id=<?= $siparis->siparis_id; ?>">Sil</a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
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
											<td class="align-middle"><?= $urun->urun_kod; ?></td>
											<td class="align-middle"><?= $urun->urun_ad; ?></td>
											<?php
												$kategori_sql = "SELECT * FROM kategoriler WHERE kategori_id=:id";
												$statement = $pdo->prepare($kategori_sql);
												$statement->execute([':id' => $urun->urun_kategori]);
												$kategori = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $kategori->kategori_ad; ?></td>
											<td class="text-center align-middle text-success"><strong><?= $urun->urun_fiyat; ?> ₺</strong></td>
											<td class="text-center align-middle"><a class="text-info font-weight-bold" href="urun-guncelle.php?id=<?= $urun->urun_id; ?>">Düzenle</a> | <a class="text-danger font-weight-bold" href="urun-sil.php?id=<?= $urun->urun_id; ?>">Sil</a></td>
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
											<td class="align-middle"><?= $kategori->kategori_ad; ?></td>
											<?php
												$ust_kategori_sql = "SELECT kategori_ad FROM kategoriler WHERE kategori_id=:id";
												$statement = $pdo->prepare($ust_kategori_sql);
												$statement->execute([':id' => $kategori->kategori_ust]);
												$ust_kategori = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<?php if($kategori->kategori_ust == 0) {?>
												<td class="align-middle text-center">YOK</td>
											<?php } else { ?>
												<td class="align-middle text-center"><?= $ust_kategori->kategori_ad; ?></td>
											<?php } ?>									
											<td class="text-center align-middle"><a class="text-info font-weight-bold" href="kategori-guncelle.php?id=<?= $kategori->kategori_id; ?>">Düzenle</a> | <a class="text-danger font-weight-bold" href="kategori-sil.php?id=<?= $kategori->kategori_id; ?>">Sil</a></td>
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
											<td class="align-middle"><?= $kullanici->kullanici_ad; ?></td>								
											<td class="align-middle"><?= $kullanici->kullanici_mail; ?></td>
											<?php
												if($kullanici->kullanici_rol == 0) {
													echo '<th class="align-middle text-center"><span class="badge badge-primary ml-2 align-middle">Müşteri</span></th>';
												} else if ($kullanici->kullanici_rol == 1) {
													echo '<th class="align-middle text-center"><span class="badge badge-danger ml-2 align-middle">Yönetici</span></th>';
												} else {
													echo '<th class="align-middle text-center"><span class="badge badge-warning ml-2 align-middle">Editör</span></th>';
												}
											?>						
											<td class="text-center align-middle"><a class="text-danger font-weight-bold" href="kullanici-sil.php?id=<?= $kullanici->kullanici_id; ?>">Sil</a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row my-5">
				<div class="col-12">
					<div class="blok bg-white border rounded shadow-sm p-3">
						<h2 class="border-bottom"><i class="fas fa-list"></i> Destek Biletleri</h2>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Bilet ID</th>
										<th scope="col"><i class="fas fa-user"></i> Bilet Sahibi</th>
										<th scope="col"><i class="fas fa-tag"></i> Bilet Başlığı</th>
										<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?php foreach($biletler as $bilet): ?>
										<tr>
											<th class="align-middle text-center" scope="row"><?= $bilet->bilet_id; ?></th>
											<?php
												$biletsahip_sql = "SELECT kullanici_ad FROM kullanicilar WHERE kullanici_id=:id";
												$statement = $pdo->prepare($biletsahip_sql);
												$statement->execute([':id' => $bilet->bilet_sahip]);
												$biletsahip = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $biletsahip->kullanici_ad; ?></td>
											<td class="align-middle"><?= $bilet->bilet_baslik; ?></td>
											<td class="text-center align-middle"><a class="text-success font-weight-bold" href="bilet-detay.php?id=<?= $bilet->bilet_id; ?>">Görüntüle | <a class="text-danger font-weight-bold" href="bilet-sil.php?id=<?= $bilet->bilet_id; ?>">Sil</a></a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
	<?php if ($user->kullanici_rol == 0) { ?>
		<div class="container">
			<div class="row my-5">
				<div class="col-12">
					<div class="blok bg-white border rounded shadow-sm p-3">
						<h2 class="border-bottom"><i class="fas fa-list"></i> Satın Alınabilir Ürünler</h2>
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
											<td class="align-middle"><?= $urun->urun_kod; ?></td>
											<td class="align-middle"><?= $urun->urun_ad; ?></td>
											<?php
												$kategori_sql = "SELECT * FROM kategoriler WHERE kategori_id=:id";
												$statement = $pdo->prepare($kategori_sql);
												$statement->execute([':id' => $urun->urun_kategori]);
												$kategori = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $kategori->kategori_ad; ?></td>
											<td class="text-center align-middle text-success"><strong><?= $urun->urun_fiyat; ?> ₺</strong></td>
											<td class="text-center align-middle"><a href="siparis.php?id=<?= $urun->urun_id; ?>&kullanici=<?= $user->kullanici_id; ?>" class="btn btn-success btn-sm" role="button" aria-pressed="true"><i class="fas fa-shopping-cart"></i> SATIN AL</a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row my-5">
				<div class="col-12">
					<div class="blok bg-white border rounded shadow-sm p-3">
						<h2 class="border-bottom"><i class="fas fa-list"></i> Satın Alınanlar</h2>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Sipariş ID</th>
										<th scope="col"><i class="fas fa-tag"></i> Ürün Adı</th>
										<th scope="col"><i class="fas fa-folder"></i> Ürün Kategorisi</th>
										<th class="text-center" scope="col"><i class="fas fa-info-circle"></i> Sipariş Durumu (Lisans)</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$siparisler_sql = "SELECT * FROM siparisler WHERE siparis_kullanici='$user->kullanici_id'";
										$statement = $pdo->prepare($siparisler_sql);
										$statement->execute();
										$siparisler = $statement->fetchAll(PDO::FETCH_OBJ);
									?>
									<?php foreach($siparisler as $siparis): ?>
										<tr>
											<th class="align-middle text-center" scope="row"><?= $siparis->siparis_id; ?></th>
											<?php
												$siparis_urun_sql = "SELECT * FROM urunler WHERE urun_id=:id";
												$statement = $pdo->prepare($siparis_urun_sql);
												$statement->execute([':id' => $siparis->siparis_urun]);
												$siparis_urun = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $siparis_urun->urun_ad; ?></td>
											<?php
												$kategori_sql = "SELECT * FROM kategoriler WHERE kategori_id=:id";
												$statement = $pdo->prepare($kategori_sql);
												$statement->execute([':id' => $siparis_urun->urun_kategori]);
												$kategori = $statement->fetch(PDO::FETCH_OBJ);
											?>
											<td class="align-middle"><?= $kategori->kategori_ad; ?></td>
											<?php if ($siparis->siparis_durum == 0) { ?>
												<td class="text-center align-middle"><span class="badge badge-warning">BEKLİYOR</span></td>
											<?php } else { ?>
												<td class="text-center align-middle"><span class="badge badge-success">AKTİF</span> (<?= $siparis->siparis_lisans; ?>)</td>
											<?php } ?>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-12">
					<div class="blok bg-white border rounded shadow-sm p-3">
						<h2 class="border-bottom"><i class="fas fa-list"></i> Destek Biletleriniz</h2>
						<div class="table-responsive">
							<table class="table table-hover table-striped table-bordered">
								<thead>
									<tr>
										<th class="text-center" scope="col"><i class="fas fa-hashtag"></i> Bilet ID</th>
										<th scope="col"><i class="fas fa-tag"></i> Bilet Başlığı</th>
										<th class="text-center" scope="col"><i class="fas fa-wrench"></i> İşlemler</th>
									</tr>
								</thead>
								<tbody>
									<?php
										$biletler_sql = "SELECT * FROM biletler WHERE bilet_sahip='$user->kullanici_id'";
										$statement = $pdo->prepare($biletler_sql);	
										$statement->execute();
										$biletler = $statement->fetchAll(PDO::FETCH_OBJ);
									?>
									<?php foreach($biletler as $bilet): ?>
										<tr>
											<th class="align-middle text-center" scope="row"><?= $bilet->bilet_id; ?></th>
											<td class="align-middle"><?= $bilet->bilet_baslik; ?></td>
											<td class="text-center align-middle"><a class="text-success font-weight-bold" href="bilet-detay.php?id=<?= $bilet->bilet_id; ?>">Görüntüle</a></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	<?php } ?>
<?php require_once('footer.php'); ?>
