
<?php
require_once '../admin/db_files/dbase.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'fetch') {
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
