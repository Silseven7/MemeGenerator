<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!isset($_FILES['image']) || $_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        die('Error uploading file. Please try again.');
    }

    
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
    if (!in_array($_FILES['image']['type'], $allowedTypes)) {
        die('Invalid file type. Please upload a JPG, PNG, or GIF image.');
    }

   
    $imageData = file_get_contents($_FILES['image']['tmp_name']);
    $base64Image = base64_encode($imageData);
    $imageType = $_FILES['image']['type'];

    
    $topText = strtoupper($_POST['top_text'] ?? '');
    $bottomText = strtoupper($_POST['bottom_text'] ?? '');
    $fontSize = max(10, min(100, intval($_POST['font_size'] ?? 30)));
    $fontFamily = $_POST['font'] ?? 'Impact';

    
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <title>Your Meme</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
        <style>
            body {
                background-color: #1a1a1a;
                padding: 20px;
                color: #ffffff;
            }
            .container {
                max-width: 800px;
                background-color: #2d2d2d;
                padding: 30px;
                border-radius: 15px;
                box-shadow: 0 0 20px rgba(0,0,0,0.3);
            }
            .meme-wrapper {
                position: relative;
                display: inline-block;
                margin: 20px 0;
                background-color: #363636;
                padding: 20px;
                border-radius: 10px;
            }
            .meme-image {
                max-width: 100%;
                display: block;
                border-radius: 8px;
                box-shadow: 0 0 10px rgba(0,0,0,0.2);
            }
            .meme-text {
                position: absolute;
                width: 100%;
                text-align: center;
                color: white;
                text-shadow: 2px 2px 2px black;
                font-weight: bold;
                padding: 10px;
            }
            .download-btn {
                margin: 10px;
                padding: 10px 25px;
                font-weight: 500;
            }
            .btn-primary {
                background-color: #007bff;
                border: none;
            }
            .btn-primary:hover {
                background-color: #0056b3;
            }
            .btn-secondary {
                background-color: #6c757d;
                border: none;
            }
            .btn-secondary:hover {
                background-color: #5a6268;
            }
            h2 {
                color: #ffffff;
            }
        </style>
    </head>
    <body>
        <div class="container text-center">
            <h2 class="mb-4">Your Meme is Ready!</h2>
            <div class="meme-wrapper" id="memeWrapper">
                <img src="data:<?php echo $imageType; ?>;base64,<?php echo $base64Image; ?>" class="meme-image" alt="Generated Meme">
                <?php if ($topText): ?>
                    <div class="meme-text" style="top: 0; font-family: <?php echo $fontFamily; ?>; font-size: <?php echo $fontSize; ?>px;">
                        <?php echo htmlspecialchars($topText); ?>
                    </div>
                <?php endif; ?>
                <?php if ($bottomText): ?>
                    <div class="meme-text" style="bottom: 0; font-family: <?php echo $fontFamily; ?>; font-size: <?php echo $fontSize; ?>px;">
                        <?php echo htmlspecialchars($bottomText); ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="mt-4">
                <button onclick="downloadMeme()" class="btn btn-primary download-btn">Download Meme with Text</button>
                <a href="data:<?php echo $imageType; ?>;base64,<?php echo $base64Image; ?>" download="original_image" class="btn btn-secondary download-btn">Download Original Image</a>
                <a href="index.php" class="btn btn-secondary download-btn">Create Another Meme</a>
            </div>
        </div>

        <script>
            function downloadMeme() {
                const element = document.getElementById('memeWrapper');
                html2canvas(element, {
                    backgroundColor: null,
                    scale: 2 
                }).then(canvas => {
                    const link = document.createElement('a');
                    link.download = 'meme.png';
                    link.href = canvas.toDataURL('image/png');
                    link.click();
                });
            }
        </script>
    </body>
    </html>
    <?php
} else {
    header('Location: index.php');
}
?>
