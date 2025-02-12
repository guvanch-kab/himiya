<style>
    .cont {
        height: auto;
        padding: 0 10px;
        border-left: 22px solid #47e027;
        height: 25px;
    }

    .custom-btn {
        min-width: 120px;
        /* Buton genişliğini artırıyoruz */

        font-size: 14px;
        /* Yazı boyutunu netleştiriyoruz */
        white-space: nowrap;
        /* Uzun metinlerin alt satıra geçmesini önlüyoruz */
        text-align: center;
        /* Metni ortalıyoruz */
        margin: 0 6px;
    }
</style>

<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12 cont">
            <h4 style="border-bottom: 1px solid #47e027; padding:2px 0;">Nazary maglumatlar</h4>
        </div>
    </div>

    <div class="row" style="padding:20px 0; border-bottom: 1px solid #518fa8;">

        <div class="col-md-9 main_place">
            <!----------------- form------->
            <form id="add_Product" enctype="multipart/form-data">

                <div class="row" style="margin-left:2px; background-color: #dbeaea;">
                    <div class="col-md-8" style=" padding-bottom: 10px; margin-top: 10px;">
                        <!-- Input ve Butonları İçeren Flexbox -->
                        <div class="d-flex align-items-center;">
                            <!-- Input Alanı -->
                            <input type="text" id="bolum_input" class="form-control " placeholder="Bölüm adyny yaz"
                                style="border:1px solid #5e5eff;">
                            <!-- Ekle Butonu -->
                            <button id="add_bolum" class="btn btn-success  custom-btn">Bölüm +</button>
                            <!-- Sil Butonu -->
                            <button id="delete_bolum" class="btn btn-danger custom-btn">Bölüm poz</button>
                        </div>
                    </div>
                </div>
                
                <div class="row" style="padding: 10px 0;">

                    <div class="col">
                        <label for="exampleFormControlSelect1">Bölüm (bap) belgisi</label>
                        <select class="form-control" id="bolum_select" style="margin-bottom:12px;font-size:14px" required>
                            <option selected disabled value="">Bölüm (bap) sayla</option>

                        </select>
                    </div>

                    <div class="col">
                        <label for="name">Bölüm (bap) Ady</label><span style="font-size: 12px; padding:0 4px;"></span>
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
                        <label for="message">PDF faýl:</label>
                        <input type="file" class="form-control" name="pdfFile" id="pdfFile" accept="application/pdf" required>
                    </div>
                </div>

                <div class="row" style="padding-bottom:5px;">
                    <!-- <div class="col-md-12 form-group">
                        <label for="book_images">Surat saýlaň:</label>
                        <input type="file" class="form-control-file" name="book_images[]" id="book_images" accept="image/*" style="border: 1px solid #aeb3b3;">
                        <small class="form-text text-muted"></small>

                        <div id="imagePreview" class="mt-2">
                        </div>

                    </div> -->
                </div>

                <button type="submit" class="btn btn-primary">Sakla</button>
            </form>
        </div>

        <div class="col-md-3" style="background-color: #fff; box-shadow: 0 3px 10px rgb(0 0 0 / 0.2); border-radius:4px">

            <!------------ Paragraf we Bolum  ------------->
            <?php
            require_once '../db_files/dbase.php';


            $sql = "SELECT DISTINCT Bolum_belgi, Bolum_ady, Paragraf_ady, Paragraf_no FROM nazary_data ORDER BY Bolum_belgi";
            $result = $connect->query($sql);

            // Bölümleri gruplayarak saklamak
            $bolumler = [];
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Bölüm adı altında paragraf no ve adı bir arada saklanıyor
                    $bolumler[$row['Bolum_ady']][] = [
                        'paragraf_no' => $row['Paragraf_no'],
                        'paragraf_ady' => $row['Paragraf_ady']
                    ];
                }
            }
            $connect->close();
            ?>
            <?php foreach ($bolumler as $bolum_adi => $paragraflar): ?>
                <div class="bolum <?= htmlspecialchars($bolum_adi); ?>" style="border-bottom: 1px solid #ea4f13; margin-bottom:10px;">
                    Bolum ady:<b style="padding-left: 5px; font-size:19px;"><?= htmlspecialchars($bolum_adi); ?></b>
                    <?php foreach ($paragraflar as $paragraf): ?>
                        <div style="text-align:left; padding:4px; color: #3d78dc;">
                            <span style="padding: 0 1px;">§</span> <?= htmlspecialchars($paragraf['paragraf_no']); ?>
                            <a href="#"
                                class="paragraph_select"
                                data-paragraph-no="<?= htmlspecialchars($paragraf['paragraf_no']); ?>"
                                data-paragraph-name="<?= htmlspecialchars($paragraf['paragraf_ady']); ?>">
                                <?= htmlspecialchars($paragraf['paragraf_ady']); ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
            <!-------------  end Paragraf we Bolum  ------------->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" id="main_pl"></div>
    </div>

    <div id="response"></div>
</div><!--end div cont-fluid---->

<script>
    $('#book_images').on('change', function() {
        const files = this.files;
        const previewContainer = $('#imagePreview');
        previewContainer.empty();

        $.each(files, function(index, file) {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();

                reader.onload = function(e) {

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

<script src="call_pages/js_files/insert_data.js"></script>

<script>
    $(function() {
        $(document).on("click", ".paragraph_select", function(e) {
            e.preventDefault();

            var paragraphNo = $(this).data("paragraph-no");
            var paragraphName = $(this).data("paragraph-name");
            $.ajax({
                url: "call_pages/get_paragraph_data.php", // Veri çekeceğiniz PHP dosyası
                type: "POST",
                data: {
                    paragraf_no: paragraphNo,
                    paragraf_ady: paragraphName
                },
                success: function(response) {
                    $("#main_pl").html(response);
                },
                error: function() {
                    alert("Bir hata oluştu, lütfen tekrar deneyin.");
                }
            });
        });
    })
</script>

<script src="call_pages/js_files/add_remove_depart.js"></script>