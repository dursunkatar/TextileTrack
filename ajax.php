<?php
require_once "db.php";
switch ($_GET['islem']) {
    case "kumasekle":
        $sorgu = "INSERT INTO kumasmodelleri (Model)
                    SELECT * FROM (SELECT '" . $_POST['kumasmodel'] . "') AS tmp
                    WHERE NOT EXISTS (
                        SELECT Model FROM kumasmodelleri WHERE Model = '" . $_POST['kumasmodel'] . "'
                    ) LIMIT 1";
        $stmt = $db->prepare($sorgu);
        $insert = $stmt->execute();
        echo $insert ? $db->lastInsertId() : 0;
        break;
    case "kumassil":
        $stmt = $db->prepare("delete FROM  kumasmodelleri WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "kumasguncelle":
        $stmt = $db->prepare("UPDATE `kumasmodelleri` SET `Model`='" . $_POST['kumasmodel'] . "' WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "kumasstokgiris":
        $sql = "INSERT INTO `kumasstok`(`KumasID`, `RenkID`, `Metropaj`, `TopAdet`,`Tarih`) VALUES (?,?,?,?,?)";
        $stmt = $db->prepare($sql);
        $insert = $stmt->execute(array(
                $_POST['kumasmodelID'],
                $_POST['renkID'],
                $_POST['metropaj'],
                $_POST['topadet'],
                time()
            )
        );
        $id = $db->lastInsertId();
        $topMetropajlar = explode(",", $_POST['topmetropajlari']);
        for ($i = 0; $i < count($topMetropajlar) - 1; $i++) {
            $sql = "INSERT INTO `kumasstoktop`(`KumasStokID`, `TopMetropaj`) VALUES (?,?)";
            $stmt = $db->prepare($sql);
            $insert = $stmt->execute(array(
                    $id,
                    $topMetropajlar[$i]
                )
            );
        }
        echo $insert ? $id : 0;
        break;
    case "urunekle":
        $sorgu = "INSERT INTO urunler (UrunAdi,UrunKodu)
                    SELECT * FROM (SELECT '" . $_POST['urun'] . "'," . $_POST['urunKod'] . ") AS tmp
                    WHERE NOT EXISTS (
                        SELECT UrunKodu FROM urunler WHERE UrunKodu = " . $_POST['urunKod'] . "
                    ) LIMIT 1";
        $stmt = $db->prepare($sorgu);
        $insert = $stmt->execute();
        echo $insert ? $db->lastInsertId() : 0;
        break;
    case "urunsil":
        $stmt = $db->prepare("delete FROM  urunler WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "urunguncelle":
        $stmt = $db->prepare("UPDATE `urunler` SET `" . $_POST['kolon'] . "`='" . $_POST['deger'] . "' WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;


    case "atolyeciekle":
        $sorgu = "INSERT INTO atolyeciler (Ad, Soyad, Gsm)
                    SELECT * FROM (SELECT '{$_POST['ad']}', '{$_POST['soyad']}', '{$_POST['gsm']}') AS tmp
                    WHERE NOT EXISTS (
                        SELECT Gsm FROM atolyeciler WHERE Gsm = '{$_POST['gsm']}'
                    ) LIMIT 1";

        $stmt = $db->prepare($sorgu);
        $insert = $stmt->execute();
        echo $insert ? $db->lastInsertId() : 0;
        break;
    case "atolyecisil":
        $stmt = $db->prepare("delete FROM  atolyeciler WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "atolyeciguncelle":
        $stmt = $db->prepare("UPDATE `atolyeciler` SET `" . $_POST['kolon'] . "`='" . $_POST['atolyeci'] . "' WHERE ID=" . $_POST['id']);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "kesimekle":
        $sql = "INSERT INTO `dikim`(`HarcananMetropaj`, `KumasModelID`, `RenkID`,  `TeslimDurum`, `Tarih`) 
                VALUES ({$_POST['ToplamGidenMetropaj']},{$_POST['KumasModelID']},{$_POST['RenkID']},'{$_POST['TeslimDurum']}'," . time() . ")";
        $stmt = $db->prepare($sql);
        $rowsCount = $stmt->execute();
        if ($rowsCount) {
            kumasStogundanDus($_POST['KumasModelID'], $_POST['RenkID'], $_POST['ToplamGidenMetropaj']);
            kumasToplarindanDus($_POST['KumasModelID'], $_POST['RenkID'], $_POST['ToplamGidenMetropaj']);
        }
        echo $rowsCount;
        break;

    case "muhasebeekle":
        $sql = "INSERT INTO `muhasebe`(`AtolyeciID`, `UrunID`,  `Adet`,  `Fason`,  `Tutar`,  `Tamir`,  `Aciklama`, `TeslimDurum`,`Tarih`) 
                VALUES ({$_POST['AtolyeciID']},{$_POST['UrunID']},{$_POST['Adet']},{$_POST['Fason']},{$_POST['Tutar']},{$_POST['Tamir']},'{$_POST['Aciklama']}','{$_POST['TeslimDurum']}'," . time() . ")";
        $stmt = $db->prepare($sql);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;

    case "muhasebeaciklama":
        $row = $db->query("select Aciklama from muhasebe where ID=" . $_GET['id'])->fetch(PDO::FETCH_ASSOC);
        echo $row['Aciklama'];
        break;
    case "avansekle":
        $sql = "INSERT INTO `avanslar`(`AtolyeciID`, `Avans`, `Not`, `Tarih`) VALUES ({$_POST['atolyeciId']},{$_POST['avans']},'{$_POST['not']}'," . time() . ")";
        $stmt = $db->prepare($sql);
        $rowsCount = $stmt->execute();
        echo $rowsCount;
        break;
    case "muhasebekayitsil":
        $idler = explode(",", $_POST['idler']);
        for ($i = 0; $i < count($idler) - 1; $i++) {
            $stmt = $db->prepare("UPDATE `muhasebe` SET `Silindi`=1 WHERE ID=" . $idler[$i]);
            $rowsCount = $stmt->execute();
        }
        echo $rowsCount;
        break;
    case "muhasebeavanskalan":
        $stmt = $db->query("SELECT 
                                    (SELECT SUM(Tutar) FROM muhasebe AS m WHERE m.Silindi=0 and m.AtolyeciID=av.AtolyeciID) - SUM(av.Avans) AS Kalan
                                    FROM avanslar AS av WHERE av.Silindi=0 and av.AtolyeciID=" . $_POST['id']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $row['Kalan'];
        break;
    case "muhasebeavanssil":
        $idler = explode(",", $_POST['idler']);
        for ($i = 0; $i < count($idler) - 1; $i++) {
            $stmt = $db->prepare("UPDATE `avanslar` SET `Silindi`=1 WHERE ID=" . $idler[$i]);
            $rowsCount = $stmt->execute();
        }
        echo $rowsCount;
        break;
    case "dikimkayitsil":
        $idler = explode(",", $_POST['idler']);

        for ($i = 0; $i < count($idler) - 1; $i++) {
            $stmt = $db->prepare("UPDATE `dikim` SET `Silindi`=1 WHERE ID=" . $idler[$i]);
            $rowsCount = $stmt->execute();
        }
        echo $rowsCount;
        break;
    case "renkekle":
        $sorgu = "INSERT INTO renkler (Renk)
                    SELECT * FROM (SELECT '" . $_POST['renkisim'] . "') AS tmp
                    WHERE NOT EXISTS (
                        SELECT Renk FROM renkler WHERE Renk = '" . $_POST['renkisim'] . "'
                    ) LIMIT 1";
        $stmt = $db->prepare($sorgu);
        $insert = $stmt->execute();
        echo $insert ? $db->lastInsertId() : 0;
        break;
    default:
        echo "Hiç biri";
}

function kumasStogundanDus($kumasModelID, $renkID, $miktar)
{
    global $db;
    $sql = "SELECT * FROM kumasstok WHERE KumasID=$kumasModelID and RenkID=$renkID and Silindi=0 limit 1";
    $kumasStok = $db->query($sql)->fetch(PDO::FETCH_ASSOC);

    if (!$kumasStok['ID']) {
        echo "kayıt yok";
        return;
    }

    if ($miktar == $kumasStok['Metropaj']) {
        $db->query("update kumasstok set Silindi=1 where ID=" . $kumasStok['ID']);
    } else if ($miktar < $kumasStok['Metropaj']) {
        $_miktar = $kumasStok['Metropaj'] - $miktar;
        $db->query("update kumasstok set Metropaj=$_miktar where ID=" . $kumasStok['ID']);
    } else if ($miktar > $kumasStok['Metropaj']) {
        $db->query("update kumasstok set Silindi=1 where ID=" . $kumasStok['ID']);
        kumasStogundanDus($kumasModelID, $renkID, $miktar - $kumasStok['Metropaj']);
    }
}

function kumasToplarindanDus($kumasModelID, $renkID, $miktar)
{
    $toplar = [];
    global $db;
    $sql = "select * from kumasstoktop where KumasStokID IN (SELECT ID FROM kumasstok WHERE Silindi=0 and KumasID=$kumasModelID AND RenkID=$renkID) order by TopMetropaj asc";
    $stmt = $db->query($sql);
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $toplar[] = $row['TopMetropaj'];
    }

    $length = count($toplar);
    $toplar = diziYenile($toplar, $miktar, $length);

    $sql = "delete from kumasstoktop where KumasStokID IN (SELECT ID FROM kumasstok WHERE Silindi=0 and KumasID=$kumasModelID AND RenkID=$renkID)";
    $db->prepare($sql)->execute();

    $row = $db->query("SELECT ID FROM kumasstok WHERE Silindi=0 and KumasID=$kumasModelID AND RenkID=$renkID ORDER BY ID DESC LIMIT 1")
        ->fetch(PDO::FETCH_ASSOC);

    $db->prepare("UPDATE kumasstok SET TopAdet=" . count($toplar) . " WHERE ID=" . $row['ID'])->execute();

    foreach ($toplar as $top) {
        $db->prepare("INSERT INTO `kumasstoktop`(`KumasStokID`, `TopMetropaj`) VALUES ({$row['ID']},$top)")->execute();
    }

    echo implode(",", $toplar);
}

function diziYenile($dizi, $miktar, $length)
{
    for ($i = 0; $i < $length; $i++) {
        if (!isset($dizi[$i])) {
            continue;
        }
        if ($miktar == $dizi[$i]) {
            unset($dizi[$i]);
            return $dizi;
        } else if ($miktar < $dizi[$i]) {
            $dizi[$i] -= $miktar;
            return $dizi;
        } else if ($miktar > $dizi[$i]) {
            $miktar = $miktar - $dizi[$i];
            unset($dizi[$i]);
            echo "büyük geldi tekrar dolaş<br />";
            diziYenile($dizi, $miktar, $length);
        }
    }
    return $dizi;
}

?>