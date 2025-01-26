<?php
require 'vendor/autoload.php'; // AWS SDK

use Aws\S3\S3Client;

// DigitalOcean Spaces configuration
$spaces = new S3Client([
    'region' => 'blr1',
    'version' => 'latest',
    'endpoint' => 'https://blr1.digitaloceanspaces.com',
    'credentials' => [
        'key' => 'DO801ANN4FV9VY6RUAVT',
        'secret' => 'wuaDS4NTWhYk8KsjmLvcIo+AgVEXZCZcDFB53vGBnHI',
    ],
    'http' => [
            'verify' => false,  // Enable SSL certificate verification
        ],
]);

if (!empty($_POST['filePath'])) {
    $filePath = $_POST['filePath'];

    // Debugging: Output the file path and bucket details
    error_log("Attempting to delete file at: attachments/" . basename($filePath));

    try {
        $spaces->deleteObject([
            'Bucket' => 'dropzoneuploads',
            'Key' => 'attachments/' . basename($filePath),
        ]);

        echo json_encode(['success' => true]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>