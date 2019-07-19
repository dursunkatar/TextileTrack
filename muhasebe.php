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

<form id="form" method="post">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Muhasebe
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md">
                                <select name="AtolyeciID" id="atolyeci" class="form-control">
                                    <option disabled selected>Atölyeci Seçiniz</option>
                                    <?php
                                    $stmt = $db->query("SELECT * FROM atolyeciler");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['ID']}'>{$row['Ad']} {$row['Soyad']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md">
                                <select name="UrunID" id="urunler" class="form-control">
                                    <option disabled selected>Ürün Seçiniz</option>
                                    <?php
                                    $stmt = $db->query("SELECT * FROM urunler");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['ID']}'>{$row['UrunAdi']} [{$row['UrunKodu']}]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md">
                                <input name="Adet" id="adet" type="text" class="form-control" placeholder="Adet">
                            </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md">
                                <input onfocusout="tutarHesapla()" id="fason" name="Fason" type="text"
                                       class="form-control"
                                       placeholder="Fason">
                            </div>
                            <div class="col-md">
                                <input id="tamir" name="Tamir" type="text" class="form-control"
                                       placeholder="Tamir">
                            </div>

                            <div class="col-md">
                                <input id="tutar" name="Tutar" type="text" class="form-control" placeholder="Tutar">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md-3">
                                <select name="TeslimDurum" id="teslim" class="form-control">
                                    <option disabled selected>Teslim Durumu</option>
                                    <option>Teslim Alındı</option>
                                    <option>Teslim Alınmadı</option>
                                </select>
                            </div>
                            <div class="col-md">
                                <textarea name="Aciklama" placeholder="Açıklama" class="form-control"></textarea>
                            </div>

                        </div>
                    </div>
                    <button type="button" onclick="kaydet()" class="btn btn-primary btn-block btn-sm">Ekle</button>
                    <br/>
                    <div id="tablom">
                        <?php
                        require_once "muhasebeTablo.php";
                        ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    Avans
                </div>
                <div style="padding-bottom: 0;" class="card-body">
                    <div class="form-group">
                        <div class="form-row">
                            <div class="col-md">
                                <select onchange="avansTablosunuYenile()" id="atolyeciavans" class="form-control">
                                    <option disabled selected>Atölyeci Seçiniz</option>
                                    <?php
                                    $stmt = $db->query("SELECT * FROM atolyeciler");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<option value='{$row['ID']}'>{$row['Ad']} {$row['Soyad']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-md">
                                <input id="avans" placeholder="avans" type="text" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md">
                                <textarea id="nott" placeholder="not" class="form-control"></textarea>
                                <br>
                                <button type="button" onclick="avansEkle()" class="btn btn-primary btn-block btn-sm">
                                    Kaydet
                                </button>
                            </div>
                        </div>
                    </div>
                    <label id="kalanavans" style="text-align: center;color:red;width: 100%;font-weight: bold;"></label>
                    <br/>
                    <div id="avanstablo">
                        <!--                        --><?php
                        //                        require_once "avansTablo.php";
                        //                        ?>
                    </div>
                </div>
            </div>

        </div>
    </div>
</form>
<div class="row">

</div>
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Not</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <label id="aciklamamodal" style="text-align: center;width: 100%"></label>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Kapat</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    let adetInput = document.getElementById('adet');
    let tutarInput = document.getElementById('tutar');
    let fasonInput = document.getElementById('fason');

    function tutarHesapla() {
        if (!fasonInput.value || !adetInput.value)
            return;

        tutarInput.value = parseInt(adetInput.value) * parseFloat(fasonInput.value);
        if (tutarInput.value.indexOf('.') != -1 && tutarInput.value.split('.')[1].length > 2) {
            tutarInput.value = parseFloat(tutarInput.value).toFixed(2);
        }
    }

    function muhasebeAciklama(id) {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            $('#aciklamamodal').text(this.responseText);
        }

        xhr.open("GET", "ajax.php?islem=muhasebeaciklama&id=" + id);
        xhr.send(null);
    }

    function kaydet() {
        tutarHesapla();
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            tabloyuYenile();
        }
        let data = new FormData(document.getElementById('form'));
        xhr.open("POST", "ajax.php?islem=muhasebeekle");
        xhr.send(data);
    }

    function tabloyuYenile() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            $('#tablom').html(this.responseText);
        }
        let data = new FormData(document.getElementById('form'));
        xhr.open("GET", "muhasebeTablo.php");
        xhr.send(null);
    }

    function avansTablosunuYenile() {
        nekadarAvansKaldi();
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            $('#avanstablo').html(this.responseText);
        }
        xhr.open("GET", "avansTablo.php?id=" + $('#atolyeciavans').val());
        xhr.send(null);
    }

    function nekadarAvansKaldi() {
        let xhr = new XMLHttpRequest();
        xhr.onload = function () {
            if (this.responseText) {
                document.getElementById('kalanavans').textContent = `Alacağı Kalan ${this.responseText} TL`;
            } else {
                document.getElementById('kalanavans').textContent = "";
            }

        }
        xhr.open("POST", "ajax.php?islem=muhasebeavanskalan");
        let data = new FormData();
        data.append('id', $('#atolyeciavans').val())
        xhr.send(data);
    }

    function avansEkle() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', "ajax.php?islem=avansekle");
        xhr.onload = function () {
            avansTablosunuYenile();
        }
        let data = new FormData();
        data.append('avans', $('#avans').val());
        data.append('not', $('#nott').val());
        data.append('atolyeciId', $('#atolyeciavans').val());
        xhr.send(data);
    }

    function kayitSil() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax.php?islem=muhasebekayitsil');
        xhr.onload = function () {
            tabloyuYenile();
        }
        let data = new FormData();
        let str = "";
        document.querySelectorAll('#muhasebetablosu input[name="idler"]:checked').forEach(function (e) {
            str += e.value + ",";
        })
        data.append('idler', str)
        xhr.send(data);
    }


    function avansSil() {
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'ajax.php?islem=muhasebeavanssil');
        xhr.onload = function () {
            avansTablosunuYenile();
        }
        let data = new FormData();
        let str = "";
        document.querySelectorAll('#avanstablosu input[name="idler"]:checked').forEach(function (e) {
            str += e.value + ",";
        })
        data.append('idler', str)
        xhr.send(data);
    }
</script>
<?php require_once "footer.php"; ?>
