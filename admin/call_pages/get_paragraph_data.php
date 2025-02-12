<?php

require_once '../db_files/dbase.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $paragraf_no = $_POST['paragraf_no'] ?? '';
    $paragraf_ady = $_POST['paragraf_ady'] ?? '';

    // Gelen veriler boş değilse, sorguya filtre ekle
    $sql = "SELECT id, Bolum_belgi, Bolum_ady, Paragraf_no, Paragraf_ady, PDF_file_ady, Surat FROM nazary_data WHERE Paragraf_ady='$paragraf_ady' ";

    if (!empty($paragraf_no)) {
        $sql .= " AND Paragraf_no = '" . $connect->real_escape_string($paragraf_no) . "'";
    }

    // if (!empty($paragraf_ady)) {
    //     $sql .= " AND Paragraf_ady LIKE '%" . $connect->real_escape_string($paragraf_ady) . "%'";
    // }
    $sql .= " ORDER BY Bolum_belgi";

    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        echo '<form id="updateForm">';
        echo '<table class="table table-bordered">';
        echo '<thead>
                <tr>
                    <th>ID</th>
                    <th>Bolum Belgi</th>
                    <th>Bolum Ady</th>
                    <th>Paragraf No</th>
                    <th>Paragraf Ady</th>
                    <th>PDF file Ady</th>
                    <th>Surat</th>
                    <th>Üýtget</th>
                    <th>Poz</th>
                </tr>
              </thead>';
        echo '<tbody>';

        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            echo '<td><input type="number" name="id_belgi[]" value="' . $row['id'] . '" class="form-control"></td>';
            echo '<td><input type="text" name="Bolum_belgi[]" value="' . htmlspecialchars($row['Bolum_belgi']) . '" class="form-control"></td>';
            echo '<td><input type="text" name="Bolum_ady[]" value="' . htmlspecialchars($row['Bolum_ady']) . '" class="form-control"></td>';
            echo '<td><input type="text" name="Paragraf_no[]" value="' . htmlspecialchars($row['Paragraf_no']) . '" class="form-control"></td>';
            echo '<td><input type="text" name="Paragraf_ady[]" value="' . htmlspecialchars($row['Paragraf_ady']) . '" class="form-control"></td>';
            echo '<td><input type="file" name="PDF_file_ady[]"  class="form-control"></td>';

            // echo '<td><input type="text" name="PDF_file_at[]" value="' . htmlspecialchars($row['PDF_file_ady']) . '" class="form-control"></td>';

            echo '<td><input type="file" name="Surat[]" class="form-control"></td>';
            echo '<td><button type="button" class="btn btn-primary update-row">Üýtget</button></td>';
            echo '<td><button type="button" class="btn btn-danger delete-row">Poz</button></td>';
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';
        echo '</form>';
    } else {
        echo "Veri bulunamadı.";
    }

    $connect->close();
}
?>

<script>
    $(function() {
        $(".update-row").click(function() {
            var row = $(this).closest("tr"); // Tıklanan satır

            // Metin alanlarından verileri al
            var id_belgi = row.find("input[name='id_belgi[]']").val();
            var bolum_belgi = row.find("input[name='Bolum_belgi[]']").val();
            var bolum_ady = row.find("input[name='Bolum_ady[]']").val();
            var paragraf_no = row.find("input[name='Paragraf_no[]']").val();
            var paragraf_ady = row.find("input[name='Paragraf_ady[]']").val();

            console.log(id_belgi)

            // Dosya inputlarını al
            var pdf_file_input = row.find("input[name='PDF_file_ady[]']")[0];
            var surat_input = row.find("input[name='Surat[]']")[0];

            // FormData nesnesi oluştur
            var formData = new FormData();
            formData.append("Id_belgi", id_belgi);
            formData.append("Bolum_belgi", bolum_belgi);
            formData.append("Bolum_ady", bolum_ady);
            formData.append("Paragraf_no", paragraf_no);
            formData.append("Paragraf_ady", paragraf_ady);

            // Eğer dosyalar seçildiyse ekle
            if (pdf_file_input.files.length > 0) {
                formData.append("PDF_file_ady", pdf_file_input.files[0]);
            }
            if (surat_input.files.length > 0) {
                formData.append("Surat", surat_input.files[0]);
            }

            // Ajax ile gönder
            $.ajax({
                url: "call_pages/update_data.php",
                type: "POST",
                data: formData,
                processData: false, // FormData'nın işlenmesine izin ver
                contentType: false, // Varsayılan içeriği devre dışı bırak
                success: function(response) {
                window.location.reload()

                },
                error: function() {
                    alert("Güncelleme sırasında bir hata oluştu.");
                },
            });
        });

        // Satır silme işlemi
        $(".delete-row").click(function () {
        if (!confirm("Bu setiri pozmak isleyanizmi?")) {
            return;
        }

        var row = $(this).closest("tr");
        var id_belgi = row.find("input[name='id_belgi[]']").val();

        $.ajax({
            url: "call_pages/delete_nazary_data.php",
            type: "POST",
            data: { Id_belgi: id_belgi },
            success: function (response) {
                alert("Setir ustunlikli pozuldy");
                row.remove(); // Tablo satırını kaldır
            },
            error: function () {
                alert("Silme sırasında bir hata oluştu.");
            },
        });
    });

    });
</script>