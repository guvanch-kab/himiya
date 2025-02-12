<?php
header('Content-Type: text/html; charset=utf-8'); // HTML çıktısı döndürmek için

require_once '../../db_files/dbase.php';

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $action_caryek = $_POST['caryek'];

    $query = "SELECT * FROM exam_result where caryek='$action_caryek' ";
    $result = mysqli_query($connect, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $html = '
        <table class="table table-bordered" style="background-color:#fff;">
            <thead>
                <tr>
                    
                    <th>Ulanyjy ID</th>
                    <th>Okuwcy Ady</th>
                    <th>Synag senesi</th>
                    <th>Netije</th>
                    <th>Dogru sany</th>
                    <th>Yalňyş sany</th>
                    <th>Çarýek</th>
                     <th>Poz</th>
                </tr>
            </thead>
            <tbody>
        ';

        while ($row = mysqli_fetch_assoc($result)) {
            $html .= '
                <tr>
                  
                    <td>' . htmlspecialchars($row['user_id']) . '</td>
                    <td>' . htmlspecialchars($row['student_name']) . '</td>
                    <td>' . htmlspecialchars($row['exam_date']) . '</td>
                    <td>' . htmlspecialchars($row['result']) . '</td>
                    <td>' . htmlspecialchars($row['correct_count']) . '</td>
                    <td>' . htmlspecialchars($row['incorrect_count']) . '</td>
                    <td>' . htmlspecialchars($row['caryek']) . '</td>
                   <td><button type="button" class="btn btn-danger delete-row" data-id="' . htmlspecialchars($row['user_id']) . '">Poz</button></td>
                </tr>
            ';
        }

        $html .= '</tbody></table>';
    } else {
        // Veri yoksa bir mesaj döndür
        $html = '<p>Maglumat tapylmady.</p>';
    }

    echo $html; // Hazır HTML tablosunu döndür
} 
}
catch (Exception $e) {
    // Hata durumunda kullanıcıya bilgi ver
    echo '<p>Bir hata oluştu: ' . htmlspecialchars($e->getMessage()) . '</p>';
}

// Bağlantıyı kapat
mysqli_close($connect);
?>

<script>
$(document).ready(function () {
    $(".delete-row").click(function () {
        if (!confirm("Bu setiri pozmak isleyanizmi?")) {
            return;
        }

        var row = $(this).closest("tr"); // Silinecek satırı belirle
        var id_belgi = $(this).data("id"); // Butonun data-id değerini al

        $.ajax({
            url: 'call_pages/question_answer/delete_row_exam.php',
            type: "POST",
            data: { Id_belgi: id_belgi }, // ID'yi gönder
            success: function (response) {
                if (response.trim() === "success") {
                    alert("Setir üstünlikli pozuldy");
                    row.remove(); // Tablo satırını kaldır
                } else {
                    alert("Silme işlemi başarısız: " + response);
                }
            },
            error: function () {
                alert("Silme sırasında bir hata oluştu.");
            },
        });
    });
});
</script>
