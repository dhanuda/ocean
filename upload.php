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


if (!empty($_FILES['file'])) {
    $file = $_FILES['file'];
    //$fileName = uniqid() . '-' . $file['name'];
    $fileName = $file['name'];
    $tempPath = $file['tmp_name'];

    try {
        $result = $spaces->putObject([
            'Bucket' => 'dropzoneuploads',
            'Key' => 'attachments/' . $fileName,
            'Body' => fopen($tempPath, 'r'),
            'ACL' => 'public-read',
        ]);

        echo json_encode(['filePath' => $result['ObjectURL']]);
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>