<div id="avanstablosu" class="table-responsive">
    <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
        <thead>
        <tr>
            <th></th>
            <th>Avans</th>
            <th>Not</th>
            <th>Tarih</th>
        </tr>
        </thead>
        <tbody>
        <?php
        require_once "db.php";
        $stmt = $db->query("SELECT a.ID, a.Avans,a.`Not`
                                        ,FROM_UNIXTIME(a.Tarih,'%d.%m.%Y') AS Tarih 
                                        FROM avanslar AS a
                                        INNER JOIN atolyeciler AS ato ON a.AtolyeciID=ato.ID
                                        WHERE a.Silindi=0 and a.AtolyeciID = {$_GET['id']}
                                        ORDER BY a.ID desc");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):?>
            <tr>
                <td><input name="idler" value="<?php echo $row['ID'] ?>" type="checkbox"></td>
                <td><?php echo $row['Avans'] ?></td>
                <td><?php echo $row['Not'] ?></td>
                <td><?php echo $row['Tarih'] ?></td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <button onclick="avansSil()" style="line-height: 27px;margin-bottom: 5px" type="button" class="btn btn-outline-dark btn-sm">Sil</button>
</div>