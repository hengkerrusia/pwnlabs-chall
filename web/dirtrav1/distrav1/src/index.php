<?php
require_once 'db.php';

// Initialize database if needed
initDatabase();

// Get all images from database
$images = getAllImages();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PhotoVault - Professional Image Gallery</title>
    <meta name="description" content="Browse our curated collection of professional photography">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>PhotoVault</h1>
            <p class="subtitle">Curated Collection of Professional Photography</p>
        </div>
    </header>

    <main class="container">
        <div class="gallery-grid">
            <?php foreach ($images as $image): ?>
            <div class="gallery-item">
                <div class="image-wrapper">
                    <img src="file.php?file=<?php echo htmlspecialchars($image['filename']); ?>" 
                         alt="<?php echo htmlspecialchars($image['title']); ?>"
                         loading="lazy">
                    <div class="image-overlay">
                        <span class="overlay-text">Click to view full size</span>
                    </div>
                </div>
                <div class="item-content">
                    <h2 class="item-title"><?php echo htmlspecialchars($image['title']); ?></h2>
                    <p class="item-description"><?php echo htmlspecialchars($image['description']); ?></p>
                    <div class="item-meta">
                        <span class="item-date">
                            <?php echo date('M d, Y', strtotime($image['upload_date'])); ?>
                        </span>
                        <a href="file.php?file=<?php echo htmlspecialchars($image['filename']); ?>" 
                           class="view-btn" 
                           target="_blank">
                            View Image
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <div class="stats">
                <div class="stat-item">
                    <div class="stat-number"><?php echo count($images); ?></div>
                    <div class="stat-label">Images</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">4K</div>
                    <div class="stat-label">Quality</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">100%</div>
                    <div class="stat-label">Professional</div>
                </div>
            </div>
            <p style="margin-top: 2rem;">&copy; 2024 PhotoVault. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
