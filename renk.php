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
                        <input onkeypress="renkInputKeypress(event)" type="text" id="renkisim" class="form-control"
                               placeholder="Renk">
                        <label for="renkisim">Renk</label>
                    </div>
                </div>
            </div>
        </div>
        <buttona onclick="renkEkle()" class="btn btn-primary btn-block">Ekle</buttona>
    </div>
    <div class="col-md-6">
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-sm" width="100%" cellspacing="0">
                <thead>
                <tr>
                    <th>Renkler</th>
                </tr>
                </thead>
                <tbody id="renktablo">
                <?php
                $stmt = $db->query("select * from renkler");
                while ($modelDS = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                    <tr>
                        <td><?php echo $modelDS['Renk']; ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">

    function renkInputKeypress(event) {
        if ((event.which | event.keyCode) === 13) {
            renkEkle();
        }
    }

    function renkEkle() {
        let model = $("input#renkisim").val();
        if(!model){
            return;
        }
        $.post("ajax.php?islem=renkekle", {renkisim: model}, (urunId) => {
            if (parseInt(urunId) > 0) {
                document.getElementById('renktablo').insertAdjacentHTML('afterbegin',
                    `<tr>
                        <td>${model}</td>
                     </tr>`);
                $("input#renkisim").val('')
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
        $.post("ajax.php?islem=kumasguncelle", {id: urunId,renkisim:self.value}, (rowCount) => {
            if (parseInt(rowCount) > 0) {
                // alert(rowCount)
            }
        });
    }
</script>
<?php require_once "footer.php"; ?>
