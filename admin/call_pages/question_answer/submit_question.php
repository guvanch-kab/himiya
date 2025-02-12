<?php
require_once '../../db_files/dbase.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $question_text = $_POST['question_text'];
    $bolum_caryek = $_POST['caryekler'];
    $options = $_POST['options'];
    $correct_answer = intval($_POST['correct_answer']);

    // JSON formatında seçenekleri hazırla
    $options_json = json_encode($options);

    $sql = "INSERT INTO questions (question_text, options, correct_answer, caryek) 
            VALUES (?, ?, ?, ?)";

    $stmt = $connect->prepare($sql);
    $stmt->bind_param("ssis", $question_text, $options_json, $correct_answer, $bolum_caryek);

    if ($stmt->execute()) {
        echo "Sorag üstünlikli goşuldy!";
    } else {
        echo "Sorag goşulanda säwlik ýüze çykdy: " . $stmt->error;
    }

    $stmt->close();
    $connect->close();
}
?>
