<style>
    .cont {
        height: auto;
        padding: 0 10px;
        border-left: 22px solid #47e027;
        height: 25px;
    }
</style>

<div class="container-fluid ">
    <div class="row">
        <div class="col-md-12 cont">
            <h4 style="border-bottom: 1px solid #47e027; padding:2px 0;">Test netijeleri</h4>
        </div>
    </div>

    <div class="row" style="padding:20px 0;">

        <div class="col-md-12 main_place">

                <div class="row" style="padding: 10px 0;">

                <div class="col-md-3" >
                <label for="exampleFormControlSelect1">Çärýekler</label>
                <select class="form-control" id="bolum_caryek" name="bolum_caryek" style="margin-bottom:12px;font-size:16px" required>
                <option selected disabled value="">Çäryek sayla</option>
                </select>
            </div>

                    <div class="col-md-3">
                        <label for="name">Synag wagty</label><span></span>
                        <input type="date" class="form-control"  id="section_date" name="section_date" >
                    </div>
                    
                </div>
                <div class="row">

                    <div class="col-md-12 form-group" id="synaglar" style=" padding-bottom:3px;">
                        <label for="message">Netijeler</label>
                        Netijeler - tablisa
                    </div>                   
                </div>
        </div>

        
    <div class="row">
        <div class="col-md-12" id="main_pl"></div>
    </div>

    <div id="response"></div>
</div><!--end div cont-fluid---->

<script>    

$(document).ready(function () {
    function fetchResults() {
        $.ajax({
            url: "call_pages/question_answer/get_exam_results.php",
            method: "GET",
            success: function (response) {
                // Dönen HTML'i doğrudan ilgili ID'ye ekle
                $("#synaglar").html(response);
            },
            error: function () {
                $("#synaglar").html("<p>Veri alınırken bir hata oluştu.</p>");
            }
        });
    }

    // Sayfa yüklendiğinde sonuçları getir
    fetchResults();
    
    $.ajax({
        url: 'call_pages/caryek_handler.php',
        type: 'POST',
        data: { action: 'fetch' },
        success: function (data) {
            $('#bolum_caryek').html('<option selected disabled value="">Caryek sayla</option>' + data);
        }
    });

    $('#bolum_caryek').on('change', function (e) {
        e.preventDefault();
     
        const selectedText = $('#bolum_caryek').find(':selected').text(); // Text değerini al
       
              $.ajax({
            url: "call_pages/question_answer/get_exam_results.php",
            type: 'POST',
            data:{caryek:selectedText},               //formData, //$(this).serialize(),
            success: function (response) {
               
                $("#synaglar").html(response);
            },
            error: function () {
                $("#synaglar").html("<p>Maglumatlar alynanda yalnyslyk yuze cykdy.</p>");
            }
        });
    });





});
    </script>


