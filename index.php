<?php
require_once "header.php";
require_once "db.php";
?>

<style type="text/css">
    select {
        cursor: pointer;
    }

    div[class^=col-md] {
        padding-bottom: 10px;
    }
</style>
<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Stok Giriş</li>
</ol>

<div class="row">
    <div class="col-md-7">
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-6">
                    <select id="kumaslar" class="form-control">
                        <option disabled selected>Kumaş Seçiniz</option>
                        <?php
                        $stmt = $db->query("SELECT * FROM kumasmodelleri");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['ID']}'>{$row['Model']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-6">
                    <select id="renkler" class="form-control">
                        <option disabled selected>Renk Seçiniz</option>
                        <?php
                        $stmt = $db->query("SELECT * FROM renkler");
                        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            echo "<option value='{$row['ID']}'>{$row['Renk']}</option>";
                        }
                        ?>
                    </select>
                </div>

            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-6">
                    <input id="metropaj" type="text" class="form-control" placeholder="Metropaj">
                </div>
                <div class="col-md-6">
                    <input id="topadet" type="text" class="form-control" placeholder="Top Adet">
                </div>
            </div>
        </div>
        <button onclick="stokEkle()" class="btn btn-primary btn-block btn-sm">Ekle</button>
    </div>
    <div class="col-md-5">
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-10">
                    <input onkeypress="topMetropajEkle(event)" id="topmetropaj" type="text" class="form-control"
                           placeholder="Top Metropaj">
                </div>
                <div class="col-md-2">
                    <button onclick="topMetropajEkle(event)" style="line-height: 27px" type="button"
                            class="btn btn-outline-dark btn-sm">Ekle
                    </button>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="card">
                        <ul id="topcm" class="list-group list-group-flush">
                        </ul>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div id="stoktablocerveve" class="col-md-12">
        <?php
        require_once "stoktablo.php";
        ?>
    </div>
</div>

<script type="text/javascript">
    let topmetropaj = document.getElementById('topmetropaj');
    let ulTopCm = document.getElementById('topcm');
    let stokTablo = document.getElementById('stoktablo');

    function topMetropajEkle(event) {
        if ((event.which | event.keyCode) === 13) {
            if( topmetropaj.value){
                ulTopCm.insertAdjacentHTML('afterbegin', `<li class="list-group-item">${topmetropaj.value}</li>`);
                topmetropaj.value = "";
            }
        }
    }

    function stokTablosunuYenile() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            $('#stoktablocerveve').html(this.responseText);
        }
        xhr.open('GET', 'stoktablo.php');
        xhr.send(null);
    }

    function stokEkle() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (parseInt(this.responseText) > 0) {
                stokTablosunuYenile()
                formuTemizle();
            }
        }
        xhr.open('POST', 'ajax.php?islem=kumasstokgiris');
        xhr.send(ajaxData());
    }

    function kumasText() {
        let kumasModel = document.getElementById('kumaslar');
        return kumasModel.options[kumasModel.selectedIndex].text;
    }

    function renkText() {
        let renkler = document.getElementById('renkler');
        return renkler.options[renkler.selectedIndex].text;
    }

    function formuTemizle() {
        $('#kumaslar').val('');
        $('#renkler').val('');
        $('#metropaj').val('');
        $('#topadet').val('');
        ulTopCm.innerHTML = "";
    }

    function topmetropajAl() {
        let _metropaj = "";
        for (let li of [...ulTopCm.children]) {
            _metropaj += li.textContent + ",";
        }
        return _metropaj;
    }

    function ajaxData() {
        let data = new FormData();
        data.append("kumasmodelID", $('#kumaslar').val());
        data.append("renkID", $('#renkler').val());
        data.append("metropaj", $('#metropaj').val());
        data.append("topadet", $('#topadet').val());
        data.append("topmetropajlari", topmetropajAl());
        return data;
    }

</script>
<?php require_once "footer.php"; ?>
