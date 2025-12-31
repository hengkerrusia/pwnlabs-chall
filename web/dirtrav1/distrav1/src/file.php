<?php
$uploadDir = '/var/www/uploads/';

if (!isset($_GET['file'])) {
    die('File parameter is required');
}

$file = $_GET['file'];
$path = $uploadDir . $file;

if (!is_file($path)) {
    die('File not found');
}

// Detect mime type based on file extension
$extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));
$mimeTypes = [
    'jpg' => 'image/jpeg',
    'jpeg' => 'image/jpeg',
    'png' => 'image/png',
    'gif' => 'image/gif',
    'webp' => 'image/webp',
    'svg' => 'image/svg+xml',
];

$contentType = isset($mimeTypes[$extension]) ? $mimeTypes[$extension] : 'text/plain';

// Set headers for file display
header('Content-Type: ' . $contentType);
header('Cache-Control: public, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Content-Length: ' . filesize($path));
header('Content-Transfer-Encoding: binary');

// Open and read the file
$handle = fopen($path, 'rb');

while (true) {
    $data = fread($handle, 8192);
    if (strlen($data) == 0) {
        break;
    }
    echo $data;
}

fclose($handle);
exit;
?>
