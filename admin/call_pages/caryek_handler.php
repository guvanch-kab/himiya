
<?php
require_once '../db_files/dbase.php';

// İstek türüne göre işlem yap
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'add') {
        $bolum = $_POST['bolum'];
        $stmt = $connect->prepare("INSERT INTO nazary_data_caryekler (caryekler) VALUES (?)");
        $stmt->bind_param("s", $bolum);

        if ($stmt->execute()) {
            echo "Bölüm ustunlikli gosuldy!";
        } else {
            echo "Bölüm gosulanda bir yalnyslyk boldy!";
        }

        $stmt->close();
    } elseif ($action == 'delete') {
        $id = $_POST['id'];
        $stmt = $connect->prepare("DELETE FROM nazary_data_caryekler WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo "Bölüm ustunlikli pozuldy!";
        } else {
            echo "Bölüm pozulanda yalnyslyk yuze caykdy!";
        }

        $stmt->close();
    } elseif ($action == 'fetch') {
        $result = $connect->query("SELECT * FROM nazary_data_caryekler");
        $options = "";

        while ($row = $result->fetch_assoc()) {
            $options .= "<option  data-name='".htmlspecialchars($row['caryekler'])."'   value='" . $row['id'] . "'>" . $row['caryekler'] . "</option>";
        }

        echo $options;
    }
}

$connect->close();
?>


<label for="exampleFormControlSelect1">Çärýekler</label>