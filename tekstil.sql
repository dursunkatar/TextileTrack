-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 20 Tem 2019, 01:47:04
-- Sunucu sürümü: 10.1.35-MariaDB
-- PHP Sürümü: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tekstil`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `atolyeciler`
--

CREATE TABLE `atolyeciler` (
  `ID` int(11) NOT NULL,
  `Ad` varchar(100) DEFAULT NULL,
  `Soyad` varchar(100) DEFAULT NULL,
  `Gsm` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `atolyeciler`
--

INSERT INTO `atolyeciler` (`ID`, `Ad`, `Soyad`, `Gsm`) VALUES
(1, 'Dursun', 'Katar', '5522242149');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `avanslar`
--

CREATE TABLE `avanslar` (
  `ID` int(11) NOT NULL,
  `AtolyeciID` int(11) NOT NULL DEFAULT '0',
  `Silindi` bit(1) NOT NULL DEFAULT b'0',
  `Avans` double NOT NULL DEFAULT '0',
  `Not` text,
  `Tarih` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `avanslar`
--

INSERT INTO `avanslar` (`ID`, `AtolyeciID`, `Silindi`, `Avans`, `Not`, `Tarih`) VALUES
(1, 1, b'0', 100, '100 tl verdim', 1563578806);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `dikim`
--

CREATE TABLE `dikim` (
  `ID` int(11) NOT NULL,
  `KumasModelID` int(11) NOT NULL DEFAULT '0',
  `RenkID` int(11) NOT NULL DEFAULT '0',
  `Silindi` bit(1) NOT NULL DEFAULT b'0',
  `HarcananMetropaj` int(11) NOT NULL DEFAULT '0',
  `TeslimDurum` varchar(100) DEFAULT NULL,
  `Tarih` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `dikim`
--

INSERT INTO `dikim` (`ID`, `KumasModelID`, `RenkID`, `Silindi`, `HarcananMetropaj`, `TeslimDurum`, `Tarih`) VALUES
(1, 1, 1, b'0', 50, 'Teslim Edildi', 1563578738);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kumasmodelleri`
--

CREATE TABLE `kumasmodelleri` (
  `ID` int(11) NOT NULL,
  `Model` varchar(100) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `kumasmodelleri`
--

INSERT INTO `kumasmodelleri` (`ID`, `Model`) VALUES
(1, 'A kumaş'),
(2, 'B Kumaş');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kumasstok`
--

CREATE TABLE `kumasstok` (
  `ID` int(11) NOT NULL,
  `KumasID` int(11) NOT NULL DEFAULT '0',
  `RenkID` int(11) NOT NULL DEFAULT '0',
  `Metropaj` double NOT NULL DEFAULT '0',
  `TopAdet` int(11) NOT NULL DEFAULT '0',
  `Silindi` tinyint(2) NOT NULL DEFAULT '0',
  `Tarih` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `kumasstok`
--

INSERT INTO `kumasstok` (`ID`, `KumasID`, `RenkID`, `Metropaj`, `TopAdet`, `Silindi`, `Tarih`) VALUES
(1, 1, 1, 50, 1, 0, 1563578670),
(2, 2, 2, 250, 3, 0, 1563578721);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kumasstoktop`
--

CREATE TABLE `kumasstoktop` (
  `KumasStokID` int(11) NOT NULL DEFAULT '0',
  `TopMetropaj` double NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `kumasstoktop`
--

INSERT INTO `kumasstoktop` (`KumasStokID`, `TopMetropaj`) VALUES
(1, 50),
(2, 160),
(2, 90),
(2, 100);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `muhasebe`
--

CREATE TABLE `muhasebe` (
  `ID` int(11) NOT NULL,
  `AtolyeciID` int(11) NOT NULL DEFAULT '0',
  `UrunID` int(11) NOT NULL DEFAULT '0',
  `UrunKodu` int(11) NOT NULL DEFAULT '0',
  `Adet` int(11) NOT NULL DEFAULT '0',
  `Fason` double NOT NULL DEFAULT '0',
  `Tutar` decimal(10,2) NOT NULL DEFAULT '0.00',
  `Tamir` double NOT NULL DEFAULT '0',
  `TeslimDurum` varchar(100) DEFAULT NULL,
  `Aciklama` text,
  `Silindi` bit(1) DEFAULT b'0',
  `Tarih` int(11) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `muhasebe`
--

INSERT INTO `muhasebe` (`ID`, `AtolyeciID`, `UrunID`, `UrunKodu`, `Adet`, `Fason`, `Tutar`, `Tamir`, `TeslimDurum`, `Aciklama`, `Silindi`, `Tarih`) VALUES
(1, 1, 1, 0, 10, 50, '500.00', 20, 'Teslim Alındı', 'teslim alındı güvenilir bir arkadaş', b'0', 1563578793);

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `renkler`
--

CREATE TABLE `renkler` (
  `ID` int(11) NOT NULL,
  `Renk` varchar(50) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `renkler`
--

INSERT INTO `renkler` (`ID`, `Renk`) VALUES
(1, 'Siyah'),
(2, 'Kırmızı'),
(3, 'Mavi'),
(4, 'Yeşil'),
(5, 'Sarı'),
(6, 'Turuncu'),
(7, 'Lacivert'),
(8, 'Bordo'),
(9, 'Haki'),
(10, 'Mürdü'),
(11, 'Beyaz'),
(12, 'Taba'),
(13, 'Saks'),
(14, 'Pudra'),
(15, 'Açık Mavi'),
(16, 'Açık Yeşil');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `urunler`
--

CREATE TABLE `urunler` (
  `ID` int(11) NOT NULL,
  `UrunAdi` varchar(100) DEFAULT NULL,
  `UrunKodu` int(11) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 ROW_FORMAT=FIXED;

--
-- Tablo döküm verisi `urunler`
--

INSERT INTO `urunler` (`ID`, `UrunAdi`, `UrunKodu`) VALUES
(1, 'A ürünü', 1001),
(2, 'B ürünü', 1002);

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `atolyeciler`
--
ALTER TABLE `atolyeciler`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `avanslar`
--
ALTER TABLE `avanslar`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `dikim`
--
ALTER TABLE `dikim`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `kumasmodelleri`
--
ALTER TABLE `kumasmodelleri`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `kumasstok`
--
ALTER TABLE `kumasstok`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `muhasebe`
--
ALTER TABLE `muhasebe`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `renkler`
--
ALTER TABLE `renkler`
  ADD PRIMARY KEY (`ID`);

--
-- Tablo için indeksler `urunler`
--
ALTER TABLE `urunler`
  ADD PRIMARY KEY (`ID`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `atolyeciler`
--
ALTER TABLE `atolyeciler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `avanslar`
--
ALTER TABLE `avanslar`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `dikim`
--
ALTER TABLE `dikim`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `kumasmodelleri`
--
ALTER TABLE `kumasmodelleri`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `kumasstok`
--
ALTER TABLE `kumasstok`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Tablo için AUTO_INCREMENT değeri `muhasebe`
--
ALTER TABLE `muhasebe`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Tablo için AUTO_INCREMENT değeri `renkler`
--
ALTER TABLE `renkler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Tablo için AUTO_INCREMENT değeri `urunler`
--
ALTER TABLE `urunler`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
