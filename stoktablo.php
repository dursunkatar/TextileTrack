<div class="table-responsive">
    <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th>Kumaş</th>
            <th>Renk</th>
            <th>Metropaj</th>
            <th>Top Adet</th>
            <th>Top Metropajları</th>
            <th>Tarih</th>
        </tr>
        </thead>
        <tbody id="stoktablo">
        <?php
        require_once "db.php";
        $stmt = $db->query("SELECT
                                                kumasmodelleri.ID AS KumasModelID,
                                                kumasmodelleri.Model,
                                                renkler.ID AS RenkID,
                                                renkler.Renk,
                                                SUM(Metropaj) AS Metropaj,
                                                SUM(TopAdet) AS TopAdet,
                                                FROM_UNIXTIME(kumasstok.Tarih,'%d.%m.%Y') AS Tarih 
                                                FROM kumasstok 
                                                INNER JOIN kumasmodelleri ON kumasstok.KumasID = kumasmodelleri.ID
                                                INNER JOIN renkler ON kumasstok.RenkID = renkler.ID
                                                where kumasstok.Silindi=0
                                                GROUP BY kumasstok.KumasID,kumasstok.RenkID");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
            <tr>
                <td><?php echo $row['Model'] ?></td>
                <td><?php echo $row['Renk'] ?></td>
                <td><?php echo $row['Metropaj'] ?></td>
                <?php
                $toplamTopSQL = "SELECT count(0) AS toplam FROM kumasstoktop WHERE kumasstoktop.KumasStokID IN (SELECT ID FROM kumasstok WHERE Silindi=0 and KumasID={$row['KumasModelID']} AND RenkID={$row['RenkID']}) ";
                $topAdetDS = $db->query($toplamTopSQL)->fetch(PDO::FETCH_ASSOC);
                echo "<td>{$topAdetDS['toplam']}</td>";
                $sql = "SELECT GROUP_CONCAT( TopMetropaj SEPARATOR ', ') AS toplar FROM kumasstoktop WHERE KumasStokID IN (SELECT ID FROM kumasstok WHERE KumasID=" . $row['KumasModelID'] . " AND RenkID=" . $row['RenkID'] . ");";
                $toplar = $db->query($sql)->fetch(PDO::FETCH_ASSOC);
                echo "<td>{$toplar['toplar']}</td>";
                ?>
                <td><?php echo $row['Tarih'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>