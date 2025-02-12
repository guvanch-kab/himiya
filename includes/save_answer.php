<?php

require_once '../admin/db_files/dbase.php';


//if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['answer'])) {
   
    $question_id = $_POST['question_id']; // Soru ID'si
    $selected_answer = $_POST['answer']; // Seçilen cevap (radio button'un value değeri)
    $user_id = $_POST['user_id'];
    $user_student = $_POST['user_student'];
    
 $created_at = date('Y-m-d H:i:s'); // Örn: 2025-01-13 14:30:00

   $today = date('Y-m-d');


    $sql = "INSERT INTO user_answers (user_id, question_id, selected_answer, senesi) 
            VALUES ($user_id, $question_id, $selected_answer, '$created_at')";




    if ($connect->query($sql) === TRUE) {
        echo "Cevap başarıyla kaydedildi.";
    } else {
        echo "Hata: " . $sql . "<br>" . $connect->error;
    }

    $connect->close();
} else {
    echo "Geçersiz istek.";
}
?>
