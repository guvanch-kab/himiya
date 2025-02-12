<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once '../../admin/db_files/dbase.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $bolumText = $_POST['bolum_caryek'];

    $_SESSION['bolumText'] = $bolumText;         

    //var_dump($bolumText);

    // Kullanıcıyı sorgula
    $stmt = $connect->prepare("SELECT id, user_password, username FROM students WHERE username = ? or phone_number= ? ");
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // Sorgudan verileri al
        $stmt->bind_result($id, $hashed_password, $db_username);
        $stmt->fetch();

        // Şifre doğrulama
        if (password_verify($password, $hashed_password)) {
           
            $_SESSION['user_id'] = $id;
            $_SESSION['username'] = $db_username;   
           

            echo 'success';
        } else {
            echo "Hatalı parola girişi!";
        }
    } else {
        echo "Kullanıcı bulunamadı!";
    }

    $stmt->close();
    $connect->close();
}
?>
