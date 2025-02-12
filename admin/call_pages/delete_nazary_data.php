<?php
require_once '../db_files/dbase.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_belgi = $_POST['Id_belgi'] ?? '';

    if (!empty($id_belgi)) {
        $sql = "DELETE FROM nazary_data WHERE id = ?";
        $stmt = $connect->prepare($sql);
        $stmt->bind_param("i", $id_belgi);

        if ($stmt->execute()) {
            echo "Setir ustunlikli pozuldy.";
        } else {
            echo "ocurme hatasy hatası: " . $connect->error;
        }

        $stmt->close();
    } else {
        echo "Degisli dal  ID.";
    }

    $connect->close();
}
?>
