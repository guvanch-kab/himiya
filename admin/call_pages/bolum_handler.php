
<?php
require_once '../db_files/dbase.php';

// İstek türüne göre işlem yap
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $bolum = $_POST['bolum'];
        $stmt = $connect->prepare("INSERT INTO nazary_data_bolumler (bolumler) VALUES (?)");
        $stmt->bind_param("s", $bolum);

        if ($stmt->execute()) {
            echo "Bölüm ustunlikli gosuldy!";
        } else {
            echo "Bölüm gosulanda bir yalnyslyk boldy!";
        }

        $stmt->close();
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $connect->prepare("DELETE FROM nazary_data_bolumler WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Bölüm başarıyla silindi!";
        } else {
            echo "Bölüm silinirken bir hata oluştu!";
        }

        $stmt->close();
    } elseif ($action == 'fetch') {
        $result = $connect->query("SELECT * FROM nazary_data_bolumler");
        $options = "";

        while ($row = $result->fetch_assoc()) {
            $options .= "<option value='" . $row['id'] . "'>" . $row['bolumler'] . "</option>";
        }

        echo $options;
    }
}

$connect->close();
?>
