<?php
// Gelen PDF dosya adını kontrol et
if (isset($_GET['file'])) {
    $pdfDosya = basename($_GET['file']); // Güvenlik için yalnızca dosya adını alıyoruz
    $pdfPath = __DIR__ . '/pdf_files/' . $pdfDosya; // PDF dosyalarının bulunduğu dizin

    // Dosya mevcut mu kontrol et
    if (file_exists($pdfPath)) {
        header('Content-Type: application/pdf');
        header('Content-Disposition: inline; filename="' . $pdfDosya . '"');
        header('Content-Length: ' . filesize($pdfPath));
        readfile($pdfPath);
        exit;
    } else {
        echo 'Dosya bulunamadı.';
    }
} else {
    echo 'Dosya parametresi eksik.';
}
?>
