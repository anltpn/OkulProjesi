<?php
	require_once 'db.php';
  
	$email = $password = '';
	$email_err = $password_err = '';

	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

		$email = trim($_POST['email']);
		$password = trim($_POST['password']);

		if(empty($email)){
		  $email_err = 'Lütfen e-posta adresinizi giriniz.';
		}

		if(empty($password)){
		  $password_err = 'Lütfen şifrenizi giriniz.';
		}

		if(empty($email_err) && empty($password_err)){
			$sql = 'SELECT * FROM kullanicilar WHERE kullanici_mail = :email';

			if($stmt = $pdo->prepare($sql)){
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				if($stmt->execute()){
					if($stmt->rowCount() === 1){
						if($row = $stmt->fetch()){
							$hashed_password = $row['kullanici_sifre'];
							if(password_verify($password, $hashed_password)){
								session_start();
								$_SESSION['email'] = $email;
								$_SESSION['name'] = $row['kullanici_ad'];
								$_SESSION['id'] = $row['kullanici_id'];
								header('Location: index.php');
							} else {
								$password_err = 'Şifre veritabanındaki ile uyuşmadı.';
							}
						}
					} else {
						$email_err = 'Bu e-posta veritabanında bulunamadı.';
					}
				} else {
				die('Bir şeyler ters gitti.');
				}
			}
		unset($stmt);
		}
		unset($pdo);
	}
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
		<title>Öğütçü Yazılım | Panel Giriş</title>
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 mx-auto">
				<div class="card card-body bg-light mt-5">
					<h2>Giriş</h2>
					<p>Lütfen bilgilerinizi doldurarak giriş yapınız.</p>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">   
						<div class="form-group">
							<label for="email">E-Posta</label>
							<input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
							<span class="invalid-feedback"><?php echo $email_err; ?></span>
						</div>
						<div class="form-group">
							<label for="password">Şifre</label>
							<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
							<span class="invalid-feedback"><?php echo $password_err; ?></span>
						</div>
						<div class="form-row">
							<div class="col">
								<input type="submit" value="Giriş" class="btn btn-success btn-block btn-lg">
							</div>
							<div class="col">
								<a href="kayit.php" class="btn btn-info btn-block btn-lg">Kayıt Ol</a>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>