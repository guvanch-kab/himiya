
<?php
session_start();

if (isset($_SESSION['user_id'])) {
    $response = [
        'status' => 'success',
        'user_id' => $_SESSION['user_id'],
        'user_name' => $_SESSION['username'],
        'bolumText' => $_SESSION['bolumText']
    ];
} else {
    $response = [
        'status' => 'error',
        'message' => 'Kullanıcı oturum bilgisi bulunamadı.'
    ];
}

echo json_encode($response);
?>
