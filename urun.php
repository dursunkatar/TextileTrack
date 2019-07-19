<?php
require_once "header.php";
require_once "db.php";
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Ürün Ekle</li>
</ol>

<div class="row">
    <div style="margin-bottom: 20px;" class="col-md-6">
        <div class="form-group ">
            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-label-group ">
                        <input type="text" id="urun" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="urun">Ürün Adı</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-label-group ">
                        <input onkeypress="urunInputKeypress(event)" type="text" id="urunKodu" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="urunKodu">Ürün Kodu</label>
                    </div>
                </div>
            </div>
        </div>
        <buttona onclick="urunEkle()" class="btn btn-primary btn-block">Ekle</buttona>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Ürün</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="uruntablo">
                <?php
                $stmt = $db->query("select * from urunler");
                while ($modelDS = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><input data-kolon="UrunAdi" onblur="urunGuncelle(<?php echo $modelDS['ID']; ?>,this)"
                                   class="form-control form-control-sm" value="<?php echo $modelDS['UrunAdi']; ?>"
                                   type="text"/></td>

                        <td><input data-kolon="UrunKodu" onblur="urunGuncelle(<?php echo $modelDS['ID']; ?>,this)"
                                   class="form-control form-control-sm" value="<?php echo $modelDS['UrunKodu']; ?>"
                                   type="text"/></td>
                        <td>
                            <button style="display:none" onclick="urunSil(<?php echo $modelDS['ID']; ?>,this)" type="button"
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

    function urunInputKeypress(event) {
        if ((event.which | event.keyCode) === 13) {
            urunEkle();
        }
    }

    function urunEkle() {
        let urun = $("input#urun").val();
        let urunKodu = $("input#urunKodu").val();
        if (!urun) {
            return;
        }
        $.post("ajax.php?islem=urunekle", {urun: urun,urunKod:urunKodu}, (urunId) => {
            if (parseInt(urunId) > 0) {
                document.getElementById('uruntablo').insertAdjacentHTML('afterbegin',
                    `<tr>
                        <td><input  data-kolon="UrunAdi"  onblur="urunGuncelle(${urunId},this)" class="form-control form-control-sm" value="${urun}" type="text"></td>
                        <td><input data-kolon="UrunKodu" onblur="urunGuncelle(${urunId},this)" class="form-control form-control-sm" value="${urunKodu}" type="text"></td>
                        <td><button style="display:none" onclick="urunSil(${urunId},this)" type="button" class="btn btn-outline-dark btn-sm">Sil</button></td>
                     </tr>`);
                $("input#urun").val('')
            }
        });
    }

    function urunSil(urunId, self) {
        $.post("ajax.php?islem=urunsil", {id: urunId}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                self.closest('tr').remove();
            }
        });
    }

    function urunGuncelle(urunId, self) {
        $.post("ajax.php?islem=urunguncelle", {id: urunId, deger: self.value,kolon:self.dataset.kolon}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                // alert(rowCount)
            }
        });
    }
</script>
<?php require_once "footer.php"; ?>
