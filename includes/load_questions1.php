<?php
require_once '../admin/db_files/dbase.php';
$bolumText = isset($_GET['bolumText']) ? $_GET['bolumText'] : null;

if (empty($bolumText)) {
    echo json_encode([
        "status" => "error",
        "message" => "<div class='alert alert-warning text-center' role='alert'>
                        <strong>Warning!</strong> Caryek seçilmedi.
                      </div>"
    ]);
    exit;
}

$stmt = $connect->prepare("SELECT * FROM questions WHERE caryek = ? ORDER BY RAND()");
$stmt->bind_param("s", $bolumText);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    // 'question_img' alanını kontrol et ve doğru yolu ekle
    $question_img = !empty($row["question_img"]) ? json_decode($row["question_img"], true) : [];

    if (!empty($question_img) && is_array($question_img)) {
        foreach ($question_img as &$img) {
            $img = "admin/call_pages/question_answer/" . $img; // Resim yolu ekleniyor
        }
    } else {
        $question_img = []; // Boş bir dizi döndürülüyor
    }

    $question = [
        "id" => $row["id"],
        "question" => $row["question_text"],
        "correct_answer" => $row["correct_answer"],
        "options" => json_decode($row["options"]), // JSON formatında seçenekler
        "question_img" => $question_img // Güncellenmiş resim yollarını kullanıyoruz
    ];
    $questions[] = $question;
}

if (empty($questions)) {
    echo json_encode([
        "status" => "error",
        "message" => "<div class='alert alert-warning text-center' role='alert'>
                        <strong>Warning!</strong> Bu Caryek için soru bulunamadı.
                      </div>"
    ]);
} else {
    echo json_encode([
        "status" => "success",
        "data" => $questions
    ]);
}

$stmt->close();
$connect->close();

?>