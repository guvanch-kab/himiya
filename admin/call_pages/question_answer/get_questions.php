<?php
require_once '../../db_files/dbase.php';

$sql = "SELECT * FROM questions";
$result = $connect->query($sql);

$options = ""; // HTML içeriği oluşturmak için
while ($row = $result->fetch_assoc()) {
    $options .= "<option value='{$row['id']}'>{$row['question_text']}</option>";
}

// HTML olarak döndür
echo $options;

$connect->close();
?>
