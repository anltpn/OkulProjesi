<?php
	require_once 'db.php';
	
	function lisans_olustur($suffix = null) {
		if(isset($suffix)){
			$num_segments = 3;
			$segment_chars = 6;
		} else {
			$num_segments = 4;
			$segment_chars = 5;
		}
		
		$tokens = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
		$license_string = '';
	
		for ($i = 0; $i < $num_segments; $i++) {
			$segment = '';
			for ($j = 0; $j < $segment_chars; $j++) {
				$segment .= $tokens[rand(0, strlen($tokens)-1)];
			}
			$license_string .= $segment;
			if ($i < ($num_segments - 1)) {
				$license_string .= '-';
			}
		}

		if(isset($suffix)){
			if(is_numeric($suffix)) {
				$license_string .= '-'.strtoupper(base_convert($suffix,10,36));
			}else{
				$long = sprintf("%u\n", ip2long($suffix),true);
				if($suffix === long2ip($long) ) {
					$license_string .= '-'.strtoupper(base_convert($long,10,36));
				}else{
					$license_string .= '-'.strtoupper(str_ireplace(' ','-',$suffix));
				}
			}
		}
		return $license_string;
	}
	
	$islem_id = $_GET["id"];
	$kullanici = $_GET["kullanici"];
	$lisans = lisans_olustur();
	$ekle_sql = "INSERT INTO siparisler (siparis_id, siparis_kullanici, siparis_urun, siparis_durum, siparis_lisans) VALUES (NULL, '$kullanici', '$islem_id', '0', '$lisans')";
    $statement = $pdo->prepare($ekle_sql);
    $statement->execute();
	
	header("Location: index.php");
	exit;
?>