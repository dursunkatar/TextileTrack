<?php
require_once "header.php";
require_once "db.php";
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Atölyeci Ekle</li>
</ol>

<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <div class="form-row">
                <div class="col-md-4">
                    <div class="form-label-group ">
                        <input onkeypress="atolyeciInputKeypress(event)" type="text" id="ad" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="ad">Ad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-label-group ">
                        <input onkeypress="atolyeciInputKeypress(event)" type="text" id="soyad" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="soyad">Soyad</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-label-group ">
                        <input onkeypress="atolyeciInputKeypress(event)" type="text" id="gsm" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="gsm">GSM</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<buttona style="margin-bottom: 15px" onclick="atolyeciEkle()" class="btn btn-primary btn-block btn-sm">Ekle</buttona>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Ad</th>
                    <th>Soyad</th>
                    <th>Gsm</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="atolyecitablo">
                <?php
                $stmt = $db->query("select * from atolyeciler");
                while ($modelDS = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><input data-kolon="ad" onblur="atolyeciGuncelle(<?php echo $modelDS['ID']; ?>,this)"
                                   class="form-control form-control-sm" value="<?php echo $modelDS['Ad']; ?>"
                                   type="text"/></td>
                        <td><input data-kolon="soyad" onblur="atolyeciGuncelle(<?php echo $modelDS['ID']; ?>,this)"
                                   class="form-control form-control-sm" value="<?php echo $modelDS['Soyad']; ?>"
                                   type="text"/></td>
                        <td><input data-kolon="gsm" onblur="atolyeciGuncelle(<?php echo $modelDS['ID']; ?>,this)"
                                   class="form-control form-control-sm" value="<?php echo $modelDS['Gsm']; ?>"
                                   type="text"/></td>
                        <td>
                            <button style="display: none"  onclick="atolyeciSil(--><?php echo $modelDS['ID']; ?>,this)" type="button"
                                    class="btn btn-outline-dark btn-sm">Sil
                            </button>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">

    function atolyeciInputKeypress(event) {
        if ((event.which | event.keyCode) === 13) {
            atolyeciEkle();
        }
    }

    function atolyeciEkle() {
        let ad = $("input#ad").val();
        let soyad = $("input#soyad").val();
        let gsm = $("input#gsm").val();

        if (!ad) {
            return;
        }
        $.post("ajax.php?islem=atolyeciekle", {ad: ad, soyad: soyad, gsm: gsm}, (atolyeciId) => {
            if (parseInt(atolyeciId) > 0) {
                document.getElementById('atolyecitablo').insertAdjacentHTML('afterbegin',
                    `<tr>
                        <td><input data-kolon="ad" onblur="atolyeciGuncelle(${atolyeciId},this)" class="form-control form-control-sm" value="${ad}" type="text"></td>
                        <td><input  data-kolon="soyad" onblur="atolyeciGuncelle(${atolyeciId},this)" class="form-control form-control-sm" value="${soyad}" type="text"></td>
                        <td><input  data-kolon="gsm" onblur="atolyeciGuncelle(${atolyeciId},this)" class="form-control form-control-sm" value="${gsm}" type="text"></td>
                         <td><button  style="display: none" onclick="atolyeciSil(${atolyeciId},this)" type="button" class="btn btn-outline-dark btn-sm">Sil</button></td>
                     </tr>`);

            }
        });
    }

    function atolyeciSil(atolyeciId, self) {
        $.post("ajax.php?islem=atolyecisil", {id: atolyeciId}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                self.closest('tr').remove();
            }
        });
    }

    function atolyeciGuncelle(atolyeciId, self) {
        $.post("ajax.php?islem=atolyeciguncelle", {
            id: atolyeciId,
            atolyeci: self.value,
            kolon: self.dataset.kolon
        }, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                // alert(rowCount)
            }
        });
    }
</script>
<?php require_once "footer.php"; ?>
