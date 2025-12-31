<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_GET['name'])) {
    header("Location: /?name=jokobi");
    die();
}

$name = $_GET['name'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penyemangat Portal | Pendukung Pro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>Pendukung Pro</h1>
                <p>Dukungan untukmu yang telah melakukan yang terbaik untuk keluarga!</p>
            </div>

            <form action="" method="GET">
                <div class="form-group">
                    <label for="name">Namamu</label>
                    <input type="text" id="name" name="name" 
                           placeholder="e.g., John Doe" 
                           value="<?php echo htmlspecialchars($name); ?>" 
                           autocomplete="off">
                </div>
                <button type="submit">Buat Dukungan</button>
            </form>

            <div class="result">
                <?php
                    $str = 'echo "Hidup, ' . $name . '!";';
                    eval($str);
                ?>
            </div>
        </div>
        <div class="footer">
            &copy; <?php echo date('Y'); ?> GreetMe Pro. All rights reserved.
        </div>
    </div>
</body>
</html>
