<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

// JSON yerine düz metin yanıt göndereceğiz
header('Content-Type: text/plain');

require_once '../db_files/dbase.php';

// Gelen verileri al
$bolum_belgi = $_POST['bolum_belgi'] ?? null;
$bolum_ady = $_POST['section_name'] ?? null;
$paragraph_no = $_POST['paragraph_no'] ?? null;
$paragraf_ady = $_POST['paragraf_ady'] ?? null;

// Zorunlu alanları kontrol et
if (!$bolum_belgi || !$bolum_ady || !$paragraph_no || !$paragraf_ady) {
    echo "Zorunlu alanlar eksik!";
    exit;
}

$uploadDir = "pdf_files/";
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0777, true)) {
        echo "Yükleme klasörü oluşturulamadı!";
        exit;
    }
}

$pdfPath = null;
if (!empty($_FILES['pdfFile']['name'])) {
    $pdfName = uniqid() . "-" . basename($_FILES['pdfFile']['name']);
    $fullPdfPath = $uploadDir . $pdfName; // Tam dosya yolu

    if (!move_uploaded_file($_FILES['pdfFile']['tmp_name'], $fullPdfPath)) {
        echo "PDF dosyası yüklenirken hata oluştu!";
        exit;
    }
    // Veritabanına sadece dosya adı kaydediliyor
    $pdfPath = $pdfName;
}


// Resim yükleme
$imagePaths = [];
if (!empty($_FILES['book_images']['name'][0])) {
    foreach ($_FILES['book_images']['name'] as $key => $name) {
        $tmpName = $_FILES['book_images']['tmp_name'][$key];
        $fileName = uniqid() . "-" . basename($name);
        $filePath = $uploadDir . $fileName;

        if (move_uploaded_file($tmpName, $filePath)) {
            $imagePaths[] = $filePath;
        } else {
            echo "Resim yüklenirken hata oluştu!";
            exit;
        }
    }
}

// Resim yollarını birleştir
$imagePathsString = implode(',', $imagePaths);

// Veritabanına veri ekleme
$sql = "INSERT INTO nazary_data (Bolum_belgi, Bolum_ady, Paragraf_no, Paragraf_ady, PDF_file_ady, Surat)
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $connect->prepare($sql);
if (!$stmt) {
    echo "Sorgu hazırlanamadı: " . $connect->error;
    exit;
}

$stmt->bind_param("ssssss", $bolum_belgi, $bolum_ady, $paragraph_no, $paragraf_ady, $pdfPath, $imagePathsString);

if ($stmt->execute()) {
    echo "Maglumatlar ustunlikli girizildi.";
} else {
    echo "Veritabanına eklenemedi: " . $stmt->error;
}

$stmt->close();
$connect->close();
