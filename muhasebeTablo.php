<style>
    table span {
        cursor: pointer;
        user-select: none;
    }

    table span:hover {
        color: red;
        font-weight: bold;
    }

    input[type=checkbox] {
        cursor: pointer;
    }
</style>



    <div class="table-responsive">
        <table id="muhasebetablosu" class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
            <thead>
            <tr>
                <th></th>
                <th>Atölyeci</th>
                <th>Ürün</th>
                <th>Ürün Kodu</th>
                <th>Adet</th>
                <th>Tamir</th>
                <th>Fason</th>
                <th>Tutar</th>
                <th>Tarih</th>
            </tr>
            </thead>
            <tbody>
            <?php
            require_once "db.php";
            $stmt = $db->query("SELECT m.ID, a.Ad,a.Soyad,u.UrunAdi,u.UrunKodu,m.Adet,m.Tamir,m.Fason,m.Tutar,m.Aciklama,FROM_UNIXTIME(m.Tarih,'%d.%m.%Y')AS Tarih 
                                        FROM muhasebe AS m
                                        INNER JOIN atolyeciler AS a ON m.AtolyeciID=a.ID
                                        INNER JOIN urunler AS u ON m.UrunID=u.ID where m.Silindi=0 ORDER BY a.Ad asc");


            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                $aciklamaVarmi = "";
                if ($row['Aciklama']) {
                    $aciklamaVarmi = " (+)";
                }
                ?>
                <tr>
                    <td><input name="idler" value="<?php echo $row['ID'] ?>" type="checkbox"></td>
                    <td><span data-toggle="modal" data-target="#exampleModal"
                              onclick="muhasebeAciklama(<?php echo $row['ID'] ?>)"><?php echo $row['Ad'] . " " . $row['Soyad'] . $aciklamaVarmi ?></span>
                    </td>
                    <td><?php echo $row['UrunAdi'] ?></td>
                    <td><?php echo $row['UrunKodu'] ?></td>
                    <td><?php echo $row['Adet'] ?></td>
                    <td><?php echo $row['Tamir'] ?></td>
                    <td><?php echo $row['Fason'] ?></td>
                    <td><?php echo para($row['Tutar']) ?></td>
                    <td><?php echo $row['Tarih'] ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
        <button onclick="kayitSil()" style="line-height: 27px" type="button" class="btn btn-outline-dark btn-sm">Sil</button>
    </div>


<?php

function para($paraStr)
{
    $para = explode(".", $paraStr);
    $yeniPara = "";
    $count = 0;
    for ($i = strlen($para[0]); $i >= 0; $i--) {
        $yeniPara .= substr($para[0], $i, 1);
        if ($count === 3) {

            $yeniPara .= ".";
            $count = 0;
        }
        $count++;
    }

    $yeniPara = strrev($yeniPara);
    if (count($para) > 1) {
        $yeniPara .= "," . $para[count($para) - 1];
    } else {
        $yeniPara .= ",00";
    }
    return substr($yeniPara, 0, 1) === "." ? substr($yeniPara, 1) : $yeniPara;
}

?>