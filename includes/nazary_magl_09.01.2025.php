<style>
.cont{height:auto; padding:0 10px; border-left:22px solid #f25426; height:25px;  }
</style>

<div class="container-fluid ">
  <div class="row">    
    <div class="col-md-12 cont">
           <h4 style="border-bottom: 1px solid #f25426; padding:2px 0;">Nazary maglumatlar</h4>
     
    </div>
</div>
<div class="row" style="padding:20px 0;">

<div class="col-md-12" >        
     
<!-------------  start ebook show  ------------>

<div class="container mt-4">
  <h3>Bölümler ve Paragraflar</h3>
  <div class="accordion" id="bolumAccordion">
    <?php
    require_once '../../admin/db_files/dbase.php';

    // Bölümleri getir (Distinct)
   // $bolumQuery = "SELECT DISTINCT Bolum_belgi, Bolum_ady FROM nazary_data ORDER BY Bolum_belgi";
   $bolumQuery = "SELECT Bolum_belgi, MAX(Bolum_ady) AS Bolum_ady FROM nazary_data GROUP BY Bolum_belgi ORDER BY Bolum_belgi";

    $bolumResult = $connect->query($bolumQuery);

    if ($bolumResult->num_rows > 0) {
        while ($bolum = $bolumResult->fetch_assoc()) {
            $bolumBelgi = $bolum['Bolum_belgi'];
            $bolumAdi = $bolum['Bolum_ady'];

            echo '<div class="accordion-item">';
            echo '<h2 class="accordion-header" id="heading' . $bolumBelgi . '">';
            echo '<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse' . $bolumBelgi . '" aria-expanded="false" aria-controls="collapse' . $bolumBelgi . '">';
            echo  '<b style="font-size:15px; padding:0 8px; color:#437da5;"> '.$bolumBelgi.'</b>'. htmlspecialchars($bolumAdi);
            echo '</button>';
            echo '</h2>'; 
            echo '<div id="collapse' . $bolumBelgi . '" class="accordion-collapse collapse" aria-labelledby="heading' . $bolumBelgi . '" data-bs-parent="#bolumAccordion">';
            echo '<div class="accordion-body">';

            // Alt paragrafları getir
            $paragrafQuery = "SELECT Paragraf_ady, Tema, Paragraf_no FROM nazary_data WHERE Bolum_belgi = ? ORDER BY Paragraf_no";
            $stmt = $connect->prepare($paragrafQuery);
            $stmt->bind_param("s", $bolumBelgi);
            $stmt->execute();
            $paragrafResult = $stmt->get_result();

            if ($paragrafResult->num_rows > 0) {
                echo '<ul>';
                while ($paragraf = $paragrafResult->fetch_assoc()) {
                    $paragrafAdy = htmlspecialchars($paragraf['Paragraf_ady']);
                    $paragrafNomeri = htmlspecialchars($paragraf['Paragraf_no']);
                    $tema = htmlspecialchars($paragraf['Tema']);

                    echo '<li>';
                    echo '<span style="padding:0 4px; color:#f25426;">§</span><span style="padding-right:6px; color:#f25426">'.$paragrafNomeri.'.</span><a href="#" class="show-tema" data-paragraphnumber="' . $paragrafNomeri . '"  data-paragraf="' . $paragrafAdy . '" data-tema="' . $tema . '">';
                    echo 'Paragraf: ' . $paragrafAdy;
                    echo '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            } else {
                echo 'Bu bölümde paragraf tapylmady.';
            }

            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p>Veritabanında bölüm bulunamadı.</p>';
    }

    $connect->close();
    ?>
  </div>

  <!-- Tema ve Paragraf Gösterim Alanı -->
  <div id="temaDisplay" class="mt-4 p-3 border bg-light" style="display: none;">
    <h4><span id="par_no"></span></h4>
    <p><strong><span style="padding:0 4px; color:#f25426;">§</span><span id="paragraphnumbero" style="padding-right:6px; color:#f25426"></span></strong>
     <span id="paragrafContent" style="color: #737373; font-size: 18px; "></span></p>
    <p><strong>Tema:</strong> <span id="temaContent"></span></p>
  </div>
</div>
<!-------------  end ebook show  ------------>
    </div>
   
</div> 
</div><!--end div cont-fluid---->

<script>
$(document).ready(function () {

    $(document).on("click", ".show-tema", function (e) {
        e.preventDefault();

        const paragraph_number = $(this).data("paragraphnumber");
        // alert(paragraph_number)
        const paragraf = $(this).data("paragraf");
        const tema = $(this).data("tema");

        // Verileri DOM'a yerleştir
        $("#paragraphnumbero").text(paragraph_number);
        $("#paragrafContent").text(paragraf);
        $("#temaContent").text(tema);

        // Gösterim alanını aç
        $("#temaDisplay").fadeIn();
    });
});
</script>
