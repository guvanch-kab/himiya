
<?php
require_once '../../db_files/dbase.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM questions WHERE id = $id";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = [
            "question_text" => $row["question_text"],
            "options" => explode(",", $row["options"]), // JSON'dan alınan seçenekleri ayır
            "correct_answer" => $row["correct_answer"]
        ];
        echo json_encode($response);
    } else {
        echo json_encode(["error" => "Question not found."]);
    }

    $connect->close();
}
?>
