<?php
// Database connection helper

function getDB() {
    $db = new PDO('sqlite:/var/www/data/gallery.db');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $db;
}

function initDatabase() {
    $db = getDB();
    
    // Create images table
    $db->exec("CREATE TABLE IF NOT EXISTS images (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        filename TEXT NOT NULL,
        title TEXT NOT NULL,
        description TEXT,
        upload_date DATETIME DEFAULT CURRENT_TIMESTAMP
    )");
    
    // Check if we already have data
    $count = $db->query("SELECT COUNT(*) FROM images")->fetchColumn();
    
    if ($count == 0) {
        // Insert sample images
        $stmt = $db->prepare("INSERT INTO images (filename, title, description) VALUES (?, ?, ?)");
        
        $images = [
            ['mountain_sunset.jpg', 'Mountain Sunset', 'Beautiful sunset over mountain peaks'],
            ['city_night.jpg', 'City Lights', 'Urban skyline at night'],
            ['forest_light.jpg', 'Forest Rays', 'Sunlight filtering through the forest'],
            ['beach_waves.jpg', 'Ocean Waves', 'Tropical beach paradise'],
            ['autumn_path.jpg', 'Autumn Path', 'Colorful fall foliage'],
            ['starry_night.jpg', 'Starry Sky', 'Milky way over mountains']
        ];
        
        foreach ($images as $image) {
            $stmt->execute($image);
        }
    }
}

function getAllImages() {
    $db = getDB();
    $stmt = $db->query("SELECT * FROM images ORDER BY upload_date DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
