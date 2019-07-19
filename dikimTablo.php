<div class="table-responsive">
    <table id="dikimtablo" class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Kumaş Modeli</th>
            <th>Renk</th>
            <th>Harcanan Metropaj</th>
            <th>Teslim Durmu</th>
            <th>Tarih</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        require_once "db.php";
        $stmt = $db->query("SELECT d.ID, model.Model,renk.Renk
                                    ,d.HarcananMetropaj,d.TeslimDurum,FROM_UNIXTIME(d.Tarih,'%d.%m.%Y') AS Tarih 
                                    FROM dikim AS d
                                                                
                                    INNER JOIN renkler AS renk ON d.RenkID =renk.ID
                                    INNER JOIN kumasmodelleri AS model ON d.KumasModelID =model.ID where d.Silindi=0 ORDER BY d.ID desc");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>

                <td><?php echo $row['Model'] ?></td>
                <td><?php echo $row['Renk'] ?></td>
                <td><?php echo $row['HarcananMetropaj'] ?></td>
                <td><?php echo $row['TeslimDurum'] ?></td>
                <td><?php echo $row['Tarih'] ?></td>
                <td><input name="idler" type="checkbox" value="<?php echo $row['ID'] ?>"></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="kayitSil()" style="line-height: 27px" type="button" class="btn btn-outline-dark btn-sm">Sil</button>
</div>