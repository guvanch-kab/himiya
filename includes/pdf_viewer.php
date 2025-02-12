<?php
// PDF dosyasının adı GET parametresinden alınır
$pdfFile = isset($_GET['file']) ? $_GET['file'] : null;

if (!$pdfFile) {
    die("PDF dosyası belirtilmedi.");
}

// PDF dosyasının tam yolu
$pdfDirectory = $_SERVER['DOCUMENT_ROOT'] . "/admin/call_pages/pdf_files/";
$pdfPath = $pdfDirectory . $pdfFile;

// Dosyanın var olup olmadığını kontrol edin
if (!file_exists($pdfPath)) {
    die("PDF dosyası bulunamadı: " . $pdfPath);
}

// Doğru Content-Type ayarı ile PDF'yi tarayıcıda görüntüleyin
header("Content-Type: application/pdf");
header("Content-Disposition: inline; filename={$pdfFile}");

header("Content-Length: " . filesize($pdfPath));

// PDF içeriğini okuyup tarayıcıya gönderin
readfile($pdfPath);
exit;
?>
