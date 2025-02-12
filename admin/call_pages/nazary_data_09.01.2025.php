<style>
.cont{height:auto; padding:0 10px; border-left:22px solid #47e027; height:25px;  }
</style>

<div class="container-fluid ">
  <div class="row">    
    <div class="col-md-12 cont">
           <h4 style="border-bottom: 1px solid #47e027; padding:2px 0;">Nazary maglumatlar</h4>
     
    </div>
</div>
<div class="row" style="padding:20px 0;">

<div class="col-md-9">        
                                                     <!----------------- form------->
<form id="add_Product" enctype="multipart/form-data">    

<div class="row" style="padding: 10px 0;">

<div class="col">
<label for="exampleFormControlSelect1">Bölüm belgisi</label>
<select class="form-control" id="bolum_select" style="margin-bottom:12px;font-size:14px" required>
            <option selected disabled value="">Bölüm sayla</option>           
            <option>I.Bölüm</option>
            <option>II.Bölüm</option>
            <option>III.Bölüm</option>
            <option>IV.Bölüm</option>
            <option>V.Bölüm</option>
            <option>VI.Bölüm</option>
            <option>VII.Bölüm</option>
        </select>
        </div>       

<div class="col">
<label for="name">Bölüm Ady</label><span style="font-size: 12px; padding:0 4px;"></span>
  <input type="text" class="form-control" placeholder="" autocomplete="off" id="section_name" name="section_name" required>
</div>
<div class="col">
<label for="name">Paragraf No</label><span style="font-size: 12px; padding:0 4px;"></span>
  <input type="text" class="form-control" placeholder="" autocomplete="off" id="paragraph_no" name="paragraph_no" required>
</div>


</div>
<div class="row">
    <div class="col-md-12 form-group" style="padding-bottom:3px;">
        <label for="message">Paragraf ady:</label>
        <textarea class="form-control" id="paragraf_ady" name="paragraf_ady" rows="3" placeholder="Paragraf adynyz yazyn" required></textarea>
    </div>

    <div class="col-md-12 form-group" style="padding-bottom:3px;">
        <label for="message">Temany kopýalaň:</label>
        <textarea class="form-control" id="tema" name="tema" rows="10" placeholder="Tema yerlesidirp bilersiniz" ></textarea>
    </div>
</div>
<div class="row" style="padding-bottom: 10px;">
<div class="col">
    <label for="book_images">Surat saýlaň:</label>
    <input type="file" class="form-control-file" name="book_images[]" id="book_images"  accept="image/*" style="border: 1px solid #aeb3b3;">
    <small class="form-text text-muted">Birden köp saýlap bilersiňiz.</small>

    <div id="imagePreview" class="mt-2">

    </div>

    </div>

</div>
   <button type="submit" class="btn btn-primary">Sakla</button>
</form>
    </div>
    <div class="col-md-3" style="background-color: #fff; margin-top:38px; box-shadow: 0 3px 10px rgb(0 0 0 / 0.2); border-radius:4px">

                                                 <!------------ Paragraf we Bolum  ------------->
<?php
require_once '../db_files/dbase.php';

$sql = "SELECT Distinct Bolum_belgi, Bolum_ady, Paragraf_no FROM nazary_data ORDER BY Bolum_belgi ";
$result = $connect->query($sql);
// Bölümleri gruplayarak saklamak
$bolumler = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $bolumler[$row['Bolum_ady']][] = $row['Paragraf_no'];
    }
}
$connect->close();
?>
<?php foreach ($bolumler as $bolum_adi => $paragraflar): ?>
    <div class="bolum <?= $bolum_adi; ?>" style="text-align: center; border-bottom: 1px solid #ea4f13; margin-bottom: 20px;">
        <b style="font-size: 14px;"><?= $bolum_adi; ?></b>
        <?php foreach ($paragraflar as $paragraf): ?>
            <div style="text-align:left; padding:4px; color: #3d78dc;">
                <span style="padding: 0 3px;">§</span> <?= htmlspecialchars($paragraf); ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
                                         <!-------------  end Paragraf we Bolum  ------------->
    </div>
</div>
<div id="response"></div>
</div><!--end div cont-fluid---->

<script>

$('#book_images').on('change', function () {
    const files = this.files;
    const previewContainer = $('#imagePreview');   
    previewContainer.empty();
    
    $.each(files, function (index, file) {
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();

            reader.onload = function (e) {
               
                const img = $('<img>')
                    .attr('src', e.target.result)
                    .attr('alt', file.name)
                    .css({
                        width: '80px',
                        marginRight: '10px',
                        marginBottom: '10px',
                        border: '1px solid #ccc',
                        borderRadius: '5px',
                    });

                previewContainer.append(img);
            };

            reader.readAsDataURL(file);
        }
    });
});


</script>


<script>
$(document).ready(function () {
    $("#add_Product").on("submit", function (e) {
        e.preventDefault();

        var formData = new FormData(this);
        var bolum_belgi = $("#bolum_select option:selected").text() || "Bilinmiyor";

        formData.append("bolum_belgi", bolum_belgi);

        $.ajax({
            url: "call_pages/insert_data.php",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                console.log("Response:", response); // Gelen yanıtı konsola yazdır

                var alertType = response.includes("ustunlikli") ? "success" : "danger";
                var alertMessage = `<div class="alert alert-${alertType}" role="alert">
                                      ${response}
                                    </div>`;
                $("#response").html(alertMessage);

                if (alertType === "success") {
                    // Yeniden veri almak ve col-md-3 kısmını güncellemek
                    $.ajax({
                        url: 'call_pages/fetch_bolum_paragraf.php', // Verileri almak için yeni PHP dosyası
                        type: 'GET',
                        success: function (data) {
                            // col-md-3 kısmını güncelle
                            $('.col-md-3').html(data);
                        }
                    });

                    setTimeout(() => location.reload(), 1000); // Sayfayı yenile
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.error("AJAX Error:", textStatus, errorThrown);
                $('#response').html(`<div class="alert alert-danger" role="alert">
                                       Bir hata oluştu: ${errorThrown || 'Bilinmeyen hata'}
                                     </div>`);
            }
        });
    });
});
</script>
