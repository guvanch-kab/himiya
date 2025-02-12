
<?php
require_once '../../db_files/dbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $question_text = $_POST['question_text'];
    $options = implode(",", explode(",", $_POST['options'])); // JSON yerine virgülle ayır
    $correct_answer = intval($_POST['correct_answer']);

    $sql = "UPDATE questions SET question_text = '$question_text', options = '$options', correct_answer = $correct_answer WHERE id = $id";

    if ($connect->query($sql) === TRUE) {
        echo "Question updated successfully!";
    } else {
        echo "Error updating question: " . $connect->error;
    }

    $connect->close();
}
?>
