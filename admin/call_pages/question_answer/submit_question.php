<?php
// require_once '../../db_files/dbase.php';

// if ($_SERVER["REQUEST_METHOD"] === "POST") {
//     $question_text = $_POST['question_text'];
//     $bolum_caryek = $_POST['caryekler'];
//     $options = $_POST['options'];
//     $correct_answer = intval($_POST['correct_answer']);

//     // JSON formatında seçenekleri hazırla
//     $options_json = json_encode($options);

//     $sql = "INSERT INTO questions (question_text, options, correct_answer, caryek) 
//             VALUES (?, ?, ?, ?)";

//     $stmt = $connect->prepare($sql);
//     $stmt->bind_param("ssis", $question_text, $options_json, $correct_answer, $bolum_caryek);

//     if ($stmt->execute()) {
//         echo "Sorag üstünlikli goşuldy!";
//     } else {
//         echo "Sorag goşulanda säwlik ýüze çykdy: " . $stmt->error;
//     }

//     $stmt->close();
//     $connect->close();
// }
?>
<?php
 require_once '../../db_files/dbase.php';

 if ($_SERVER["REQUEST_METHOD"] === "POST") {

$caryekler = isset($_POST['caryekler']) ? $_POST['caryekler'] : '';
$question_text = isset($_POST['question_text']) ? $_POST['question_text'] : '';
$correct_answer = isset($_POST['correct_answer']) ? intval($_POST['correct_answer']) : 0;
$options = isset($_FILES['options']) ? $_FILES['options'] : null;
$question_img = isset($_FILES['question_img']) ? $_FILES['question_img'] : null;

// Verileri kontrol et
if (empty($question_text) || empty($correct_answer)) {
    echo "Lütfen tüm alanları doldurun.";
    exit;
}

// Soru resmini kaydetme işlemi
$question_img_path = null;
if ($question_img && $question_img['error'] == 0) {
    $upload_dir = 'uploads/';
    $question_img_path = $upload_dir . time() . "_" . basename($question_img['name']);
    move_uploaded_file($question_img['tmp_name'], $question_img_path);
}

// Seçenekleri JSON formatına çevirme
$option_paths = [];
if ($options) {
    for ($i = 0; $i < count($options['name']); $i++) {
        if ($options['error'][$i] == 0) {
            $upload_dir = 'uploads/';
            $option_path = $upload_dir . time() . "_" . basename($options['name'][$i]);
            move_uploaded_file($options['tmp_name'][$i], $option_path);
            $option_paths[] = $option_path;
        }
    }
}

$options_json = json_encode($option_paths); // JSON formatına çevir

// Veriyi tek bir tabloya ekleme
$stmt = $connect->prepare("INSERT INTO questions (question_text, options, correct_answer, caryek, question_img ) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("ssiss", $question_text, $options_json, $correct_answer,  $caryekler, $question_img_path,  );

if ($stmt->execute()) {
    echo "Soru başarıyla eklendi!";
} else {
    echo "Hata: " . $stmt->error;
}

$stmt->close();
$connect->close();
 }

?>