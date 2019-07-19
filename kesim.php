<?php
require_once "header.php";
require_once "db.php";
?>
<style type="text/css">
    select {
        cursor: pointer;
    }

    div[class^=col-md] {
        margin-bottom: 10px;
    }
</style>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Dikim</li>
</ol>

<form id="form" method="post">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <div class="form-row">

                    <div class="col-md-3">
                        <select name="KumasModelID" id="modeller" class="form-control">
                            <option disabled selected>Kumaş Seçiniz</option>
                            <?php
                            $stmt = $db->query("SELECT * FROM kumasmodelleri");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['ID']}'>{$row['Model']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="RenkID" id="renkler" class="form-control">
                            <option disabled selected>Renk Seçiniz</option>
                            <?php
                            $stmt = $db->query("SELECT * FROM renkler");
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                echo "<option value='{$row['ID']}'>{$row['Renk']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input name="ToplamGidenMetropaj" type="text" class="form-control"
                               placeholder="Toplam Harcanan Metropaj">
                    </div>
                    <div class="col-md-3">
                        <select name="TeslimDurum" id="teslimdurum" class="form-control">
                            <option disabled selected>Teslim Durum</option>
                            <option>Teslim Edildi</option>
                            <option>Teslim Edilmedi</option>
                        </select>
                    </div>

                </div>
            </div>
            <div class="form-group">
                <div class="form-row">


                </div>
            </div>
            <button type="button" onclick="kaydet()" class="btn btn-primary btn-block btn-sm">Ekle</button>
        </div>
    </div>
</form>
<div class="row">
    <div id="tablom" class="col-md-12">
        <?php
        require_once "dikimTablo.php";
        ?>
    </div>
</div>

<script type="text/javascript">
    function kaydet() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            tabloyuYenile();
        }
        let data = new FormData(document.getElementById('form'));
        xhr.open("POST", "ajax.php?islem=kesimekle");
        xhr.send(data);
    }

    function tabloyuYenile() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            $('#tablom').html(this.responseText);
        }
        let data = new FormData(document.getElementById('form'));
        xhr.open("GET", "dikimTablo.php");
        xhr.send(null);
    }

    function kayitSil() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax.php?islem=dikimkayitsil');
        xhr.onload = function () {
            tabloyuYenile();
        }
        let data = new FormData();
        let str = "";
        document.querySelectorAll('#dikimtablo input[name="idler"]:checked').forEach(function (e) {
            str += e.value + ",";
        })
        data.append('idler', str)
        xhr.send(data);
    }
</script>
<?php require_once "footer.php"; ?>
