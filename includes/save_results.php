<?php

require_once '../admin/db_files/dbase.php';


// POST ile gelen verileri al
$userId = isset($_POST['user_id']) ? $_POST['user_id'] : '';
$studentName = isset($_POST['student_name']) ? $_POST['student_name'] : '';
$caryekal = isset($_POST['caryekal']) ? $_POST['caryekal'] : '';
$score = isset($_POST['score']) ? (int)$_POST['score'] : 0;
$correctAnswers = isset($_POST['correct_answers']) ? (int)$_POST['correct_answers'] : 0;
$incorrectAnswers = isset($_POST['incorrect_answers']) ? (int)$_POST['incorrect_answers'] : 0;

// Verilerin eksik olup olmadığını kontrol et
if (empty($userId) || empty($studentName)) {
    die("Eksik veri: user_id veya student_name boş!");
}

// Değerleri güvenli hale getir
$userId = mysqli_real_escape_string($connect, $userId);
$studentName = mysqli_real_escape_string($connect, $studentName);
//$caryek_netijesi='II.caryek';
// SQL sorgusu
$query = "INSERT INTO exam_result (user_id, student_name, result, correct_count, incorrect_count, exam_date, caryek) 
          VALUES ('$userId', '$studentName', '$score', '$correctAnswers', '$incorrectAnswers', NOW(), '$caryekal')";


// Sorguyu çalıştır
if (mysqli_query($connect, $query)) {
    echo "Sonuçlar kaydedildi.";
} else {
    echo "Hata: " . mysqli_error($connect);
}

// Veritabanı bağlantısını kapat
mysqli_close($connect);
?>