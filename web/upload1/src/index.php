<?php
require_once 'includes/header.php';

$message = '';
$messageType = '';

if (isset($_FILES['image'])) {
    // Configuration
    $uploadDir = '/var/www/html/uploads/';
    $maxFileSize = 5 * 1024 * 1024; // 5MB
    
    // Get file information
    $fileName = basename($_FILES['image']['name']);
    $fileSize = $_FILES['image']['size'];
    $tmpName = $_FILES['image']['tmp_name'];
    $targetPath = $uploadDir . $fileName;
    
    // Validate file size
    if ($fileSize > $maxFileSize) {
        $message = 'Error: File size exceeds 5MB limit.';
        $messageType = 'error';
    } else {
        // Attempt to move uploaded file
        if (move_uploaded_file($tmpName, $targetPath)) {
            $message = 'File uploaded successfully! ';
            $message .= '<a href="/uploads/' . htmlentities($fileName, ENT_QUOTES, 'UTF-8') . '" class="file-link" target="_blank">View file</a>';
            $messageType = 'success';
        } else {
            $message = 'Error: Failed to upload file. Please try again.';
            $messageType = 'error';
        }
    }
}
?>

<main class="main-content">
    <h2 class="page-title">Upload Your Files</h2>
    <p class="page-subtitle">Securely store and share your files in the cloud</p>
    
    <?php if ($message): ?>
    <div class="message <?php echo $messageType; ?>">
        <svg class="message-icon" fill="currentColor" viewBox="0 0 20 20">
            <?php if ($messageType === 'success'): ?>
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            <?php else: ?>
            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            <?php endif; ?>
        </svg>
        <span><?php echo $message; ?></span>
    </div>
    <?php endif; ?>
    
    <div class="upload-section">
        <form method="post" enctype="multipart/form-data">
            <div class="file-input-wrapper">
                <input type="file" name="image" class="file-input" required>
            </div>
            <button type="submit" class="upload-btn">Upload File</button>
        </form>
    </div>
    
    <div class="upload-info">
        <h3>Upload Guidelines</h3>
        <ul>
            <li>Maximum file size: 5MB</li>
            <li>Files are stored securely on our servers</li>
            <li>Get instant access to your uploaded files</li>
            <li>Share files easily with direct links</li>
        </ul>
    </div>
</main>

<?php
require_once 'includes/footer.php';
?>
