<?php
require_once '../../admin/db_files/dbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $phone_number = $_POST['phone_number'];
    
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);





    $checkStmt = $connect->prepare("SELECT COUNT(*) FROM students WHERE username = ? AND phone_number= ? ");
    $checkStmt->bind_param("ss", $username, $phone_number);
    $checkStmt->execute();
    $checkStmt->bind_result($userCount);
    $checkStmt->fetch();
    $checkStmt->close();

    if ($userCount > 0) {
        // Kullanıcı adı zaten varsa hata mesajı gönder
        echo "Bu ulanyjy ady eýýäm ulanyldy. Başga birini saýlaň.";
    } else {


    $stmt = $connect->prepare("INSERT INTO students (username, phone_number, user_password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $phone_number, $password);

    if ($stmt->execute()) {
        echo "Ütünlikli ýazga alyndy!";
    } else {
        echo "Hata: " . $stmt->error;
    }

    $stmt->close();
}
    $connect->close();
}
?>
