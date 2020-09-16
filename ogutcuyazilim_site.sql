-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: localhost:3306
-- Üretim Zamanı: 24 May 2020, 14:50:11
-- Sunucu sürümü: 10.3.18-MariaDB
-- PHP Sürümü: 7.3.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `ogutcuyazilim_site`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `biletler`
--

CREATE TABLE `biletler` (
  `bilet_id` int(11) NOT NULL,
  `bilet_baslik` varchar(500) NOT NULL,
  `bilet_icerik` mediumtext NOT NULL,
  `bilet_sahip` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `biletler`
--

INSERT INTO `biletler` (`bilet_id`, `bilet_baslik`, `bilet_icerik`, `bilet_sahip`) VALUES
(1, 'Ödeme bildirimi', 'Sipariş ettiğim 2 ürünün de ödemesini banka hesabınıza yaptım. Onaylar mısınız?', 3),
(2, 'SMM panel hakkında', 'Bu panel ile takipçi satışı yapabilir miyim?', 3);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kategoriler`
--

CREATE TABLE `kategoriler` (
  `kategori_id` int(11) NOT NULL,
  `kategori_ust` int(11) NOT NULL,
  `kategori_ad` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kategoriler`
--

INSERT INTO `kategoriler` (`kategori_id`, `kategori_ust`, `kategori_ad`) VALUES
(1, 0, 'Sosyal Medya'),
(2, 0, 'Web'),
(3, 0, 'Yardımcı Yazılımlar'),
(4, 0, 'E-Ticaret'),
(5, 0, 'Masaüstü Yazılımlar'),
(7, 5, 'İş Yazılımları'),
(8, 5, 'Takip Yazılımları');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

CREATE TABLE `kullanicilar` (
  `kullanici_id` int(11) NOT NULL,
  `kullanici_mail` varchar(255) NOT NULL,
  `kullanici_ad` varchar(255) NOT NULL,
  `kullanici_sifre` varchar(500) NOT NULL,
  `kullanici_rol` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`kullanici_id`, `kullanici_mail`, `kullanici_ad`, `kullanici_sifre`, `kullanici_rol`) VALUES
(2, 'mert@canugurlu.com.tr', 'Mert Can Uğurlu', '$2y$10$Bx7cc7wQHC08j8FSYiygxeOpCBvYzK0AGq58vke7v.f5APQsu./9W', 1),
(3, 'demomusteri@ogutcuyazilim.site', 'Demo Müşteri', '$2y$10$JzwWvYkv5k2dN43ESMhyfuDCX9WjDl9NqDWMxwYU52h0soj4v4wR2', 0),
(4, 'demoeditor@ogutcuyazilim.site', 'Demo Editör', '$2y$10$b9wCky64foz.6SLiK5/UR.GzGnu5KeTw59JESuRtcMfKBL2yDDg0W', 2),
(5, 'anil.tapann@gmail.com', 'Anıl Can Tapan', '$2y$10$vMA7GVKxA7g11LhQTYGmDOJSR4enjOOV41JrGwEdO4aCQBlwSoQKi', 1);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `siparisler`
--

CREATE TABLE `siparisler` (
  `siparis_id` int(11) NOT NULL,
  `siparis_kullanici` int(11) NOT NULL,
  `siparis_urun` int(11) NOT NULL,
  `siparis_durum` tinyint(1) NOT NULL,
  `siparis_lisans` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `siparisler`
--

INSERT INTO `siparisler` (`siparis_id`, `siparis_kullanici`, `siparis_urun`, `siparis_durum`, `siparis_lisans`) VALUES
(1, 3, 2, 1, 'A5VX3-J3554-XU25V-2LDLN'),
(2, 3, 6, 0, 'ABKT2-G2JK3-8WNZA-DNWVG');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `urun_id` int(11) NOT NULL,
  `urun_kod` varchar(60) NOT NULL,
  `urun_ad` varchar(255) NOT NULL,
  `urun_kategori` int(11) NOT NULL,
  `urun_fiyat` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`urun_id`, `urun_kod`, `urun_ad`, `urun_kategori`, `urun_fiyat`) VALUES
(2, 'FDK456', 'Instagram Account Creator', 1, 2500),
(3, 'GHJ652', 'Twitter Account Creator', 1, 2500),
(4, 'GNB512', 'Pinterest Account Creator', 1, 1500),
(5, 'HGJ122', 'Google Business Bot', 2, 750),
(6, 'BHG124', 'Instagram Web Scraper', 1, 500),
(7, 'GBS123', 'Öğüt SMM Panel', 4, 1500);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `yanitlar`
--

CREATE TABLE `yanitlar` (
  `yanit_id` int(11) NOT NULL,
  `yanit_bilet` int(11) NOT NULL,
  `yanit_kullanici` int(11) NOT NULL,
  `yanit_icerik` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Tablo döküm verisi `yanitlar`
--

INSERT INTO `yanitlar` (`yanit_id`, `yanit_bilet`, `yanit_kullanici`, `yanit_icerik`) VALUES
(1, 1, 4, 'Merhaba.\r\n\r\nÜrünleriniz onaylanmıştır!\r\n\r\nİyi çalışmalar.');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `biletler`
--
ALTER TABLE `biletler`
  ADD PRIMARY KEY (`bilet_id`);

--
-- Tablo için indeksler `kategoriler`
--
ALTER TABLE `kategoriler`
  ADD PRIMARY KEY (`kategori_id`);

--
-- Tablo için indeksler `kullanicilar`
--
ALTER TABLE `kullanicilar`
  ADD PRIMARY KEY (`kullanici_id`);

--
-- Tablo için indeksler `siparisler`
--
ALTER TABLE `siparisler`
  ADD PRIMARY KEY (`siparis_id`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`urun_id`);

--
-- Tablo için indeksler `yanitlar`
--
ALTER TABLE `yanitlar`
  ADD PRIMARY KEY (`yanit_id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `biletler`
--
ALTER TABLE `biletler`
  MODIFY `bilet_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kategoriler`
--
ALTER TABLE `kategoriler`
  MODIFY `kategori_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Tablo için AUTO_INCREMENT değeri `kullanicilar`
--
ALTER TABLE `kullanicilar`
  MODIFY `kullanici_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Tablo için AUTO_INCREMENT değeri `siparisler`
--
ALTER TABLE `siparisler`
  MODIFY `siparis_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `urun_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Tablo için AUTO_INCREMENT değeri `yanitlar`
--
ALTER TABLE `yanitlar`
  MODIFY `yanit_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
