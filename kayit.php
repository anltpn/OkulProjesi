<?php
	require_once 'db.php';

	$name = $email = $password = $confirm_password = '';
	$name_err = $email_err = $password_err = $confirm_password_err = '';
	
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
		
		$name =  trim($_POST['name']);
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
		$confirm_password = trim($_POST['confirm_password']);
		
		if(empty($email)){
			$email_err = 'Please enter email';
		} else {
			$sql = 'SELECT kullanici_id FROM kullanicilar WHERE kullanici_mail = :email';
			if($stmt = $pdo->prepare($sql)){
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				if($stmt->execute()){
					if($stmt->rowCount() === 1){
						$email_err = 'Bu e-posta adresi daha önce alınmış.';
					}
				} else {
					die('Bir şeyler ters gitti.');
				}
			}
			unset($stmt);
		}

		if(empty($name)){
			$name_err = 'Lütfen isminizi giriniz.';
		}

		if(empty($password)){
			$password_err = 'Lütfen bir şifre giriniz.';
		} elseif(strlen($password) < 6){
			$password_err = 'Şifreniz en az 6 karakterden oluşmalıdır.';
		}

		if(empty($confirm_password)){
			$confirm_password_err = 'Lütfen şifrenizi tekrardan giriniz.';
		} else {
			if($password !== $confirm_password){
				$confirm_password_err = 'Girdiğiniz şifreler uyuşmuyor.';
			}
		}

		if(empty($name_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
			$password = password_hash($password, PASSWORD_DEFAULT);
			
			$sql = 'INSERT INTO kullanicilar (kullanici_ad, kullanici_mail, kullanici_sifre) VALUES (:name, :email, :password)';

			if($stmt = $pdo->prepare($sql)){
				$stmt->bindParam(':name', $name, PDO::PARAM_STR);
				$stmt->bindParam(':email', $email, PDO::PARAM_STR);
				$stmt->bindParam(':password', $password, PDO::PARAM_STR);
				
				if($stmt->execute()){
					header('Location: giris.php');
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
		<title>Ögütçü Yazılım | Panel Kayıt</title>
	</head>
	<body>
	<div class="container">
		<div class="row">
			<div class="col-md-6 mx-auto">
				<div class="card card-body bg-light mt-5">
					<h2>Kayıt</h2>
					<p>Lütfen bilgilerinizi doldurarak kayıt olunuz.</p>
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
						<div class="form-group">
							<label for="name">İsim</label>
							<input type="text" name="name" class="form-control form-control-lg <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
							<span class="invalid-feedback"><?php echo $name_err; ?></span>
						</div>
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
						<div class="form-group">
							<label for="confirm_password">Şifre (tekrar)</label>
							<input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
							<span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
						</div>
						<div class="form-row">
							<div class="col">
								<input type="submit" value="Kayıt" class="btn btn-info btn-block btn-lg">
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
</html>