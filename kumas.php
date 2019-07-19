<?php
require_once "header.php";
require_once "db.php";
?>

<!-- Breadcrumbs-->
<ol class="breadcrumb">
    <li class="breadcrumb-item active">Kumaş Ekle</li>
</ol>

<div class="row">
    <div style="margin-bottom: 20px;" class="col-md-6">
        <div class="form-group ">
            <div class="form-row">
                <div class="col-md-12">
                    <div class="form-label-group ">
                        <input onkeypress="kumasInputKeypress(event)" type="text" id="kumasmodel" class="form-control"
                               placeholder="Kumaş Modeli">
                        <label for="kumasmodel">Kumaş Modeli</label>
                    </div>
                </div>
            </div>
        </div>
        <buttona onclick="kumasEkle()" class="btn btn-primary btn-block">Ekle</buttona>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Kumaş Modeli</th>
                    <th></th>
                </tr>
                </thead>
                <tbody id="kumasmodeltablo">
                <?php
                $stmt = $db->query("select * from kumasmodelleri");
                while ($modelDS = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><input onblur="kumasGuncelle(<?php echo $modelDS['ID']; ?>,this)" class="form-control form-control-sm" value="<?php echo $modelDS['Model']; ?>" type="text"/> </td>
                        <td>
                            <button style="display:none" onclick="kumasSil(<?php echo $modelDS['ID']; ?>,this)" type="button"
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

    function kumasInputKeypress(event) {
        if ((event.which | event.keyCode) === 13) {
            kumasEkle();
        }
    }

    function kumasEkle() {
        let model = $("input#kumasmodel").val();
        if(!model){
            return;
        }
        $.post("ajax.php?islem=kumasekle", {kumasmodel: model}, (urunId) => {
            if (parseInt(urunId) > 0) {
                document.getElementById('kumasmodeltablo').insertAdjacentHTML('afterbegin',
                    `<tr>
                        <td><input onblur="kumasGuncelle(${urunId},this)" class="form-control form-control-sm" value="${model}" type="text"></td>
                        <td><button style="display:none" onclick="kumasSil(${urunId},this)" type="button" class="btn btn-outline-dark btn-sm">Sil</button></td>
                     </tr>`);
                $("input#kumasmodel").val('')
            }
        });
    }

    function kumasSil(urunId, self) {
        $.post("ajax.php?islem=kumassil", {id: urunId}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                self.closest('tr').remove();
            }
        });
    }

    function kumasGuncelle(urunId,self) {
        $.post("ajax.php?islem=kumasguncelle", {id: urunId,kumasmodel:self.value}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
             // alert(rowCount)
            }
        });
    }
</script>
<?php require_once "footer.php"; ?>
