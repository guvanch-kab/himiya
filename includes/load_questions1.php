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

// Hazırlanmış ifade kullanarak sorgu hazırlıyoruz
$stmt = $connect->prepare("SELECT * FROM questions WHERE caryek = ? ORDER BY RAND()");
$stmt->bind_param("s", $bolumText);
$stmt->execute();
$result = $stmt->get_result();

$questions = [];
while ($row = $result->fetch_assoc()) {
    $question = [
        "id" => $row["id"],
        "question" => $row["question_text"],
        "correct_answer" => $row["correct_answer"],
        "options" => json_decode($row["options"])
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