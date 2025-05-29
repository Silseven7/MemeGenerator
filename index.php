<!DOCTYPE html>
<html>
<head>
    <title>Meme Generator</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
        .preview-container {
            margin-top: 20px;
            text-align: center;
            display: none;
            background-color: #363636;
            padding: 20px;
            border-radius: 10px;
        }
        #imagePreview {
            max-width: 100%;
            max-height: 400px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.2);
        }
        .text-preview {
            position: absolute;
            width: 100%;
            text-align: center;
            color: white;
            text-shadow: 2px 2px 2px black;
            font-weight: bold;
            padding: 10px;
        }
        .preview-wrapper {
            position: relative;
            display: inline-block;
            margin: 20px 0;
        }
        .form-label {
            color: #ffffff;
            font-weight: 500;
        }
        .form-control, .form-select {
            background-color: #363636;
            border: 1px solid #4a4a4a;
            color: #ffffff;
        }
        .form-control:focus, .form-select:focus {
            background-color: #404040;
            border-color: #5a5a5a;
            color: #ffffff;
            box-shadow: 0 0 0 0.25rem rgba(255,255,255,0.1);
        }
        .form-range::-webkit-slider-thumb {
            background: #007bff;
        }
        .form-range::-moz-range-thumb {
            background: #007bff;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px 25px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        h2, h4 {
            color: #ffffff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2 class="text-center mb-4">Meme Generator</h2>
        <form action="generate.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="form-label">Select Image:</label>
                <input type="file" class="form-control" name="image" accept="image/*" required onchange="previewImage(this)">
            </div>

            <div class="mb-3">
                <label class="form-label">Top Text:</label>
                <input type="text" class="form-control" name="top_text" onkeyup="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="form-label">Bottom Text:</label>
                <input type="text" class="form-control" name="bottom_text" onkeyup="updatePreview()">
            </div>

            <div class="mb-3">
                <label class="form-label">Font Size (px):</label>
                <input type="range" class="form-range" name="font_size" min="10" max="100" value="30" onchange="updatePreview()">
                <div class="text-center" id="fontSizeValue">30px</div>
            </div>

            <div class="mb-3">
                <label class="form-label">Select Font:</label>
                <select class="form-select" name="font" onchange="updatePreview()">
                    <option value="Arial">Arial</option>
                    <option value="Impact">Impact</option>
                    <option value="Comic Sans MS">Comic Sans MS</option>
                    <option value="Verdana">Verdana</option>
                    <option value="Tahoma">Tahoma</option>
                </select>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-primary">Generate Meme</button>
            </div>
        </form>

        <div class="preview-container" id="previewContainer">
            <h4>Preview</h4>
            <div class="preview-wrapper">
                <img id="imagePreview" src="" alt="Preview">
                <div class="text-preview" id="topTextPreview" style="top: 0;"></div>
                <div class="text-preview" id="bottomTextPreview" style="bottom: 0;"></div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                    document.getElementById('previewContainer').style.display = 'block';
                    updatePreview();
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function updatePreview() {
            const fontSize = document.querySelector('input[name="font_size"]').value;
            document.getElementById('fontSizeValue').textContent = fontSize + 'px';
            
            const topText = document.querySelector('input[name="top_text"]').value;
            const bottomText = document.querySelector('input[name="bottom_text"]').value;
            const selectedFont = document.querySelector('select[name="font"]').value;
            
            const topPreview = document.getElementById('topTextPreview');
            const bottomPreview = document.getElementById('bottomTextPreview');
            
            topPreview.textContent = topText;
            bottomPreview.textContent = bottomText;
            
            topPreview.style.fontSize = fontSize + 'px';
            bottomPreview.style.fontSize = fontSize + 'px';
            
            topPreview.style.fontFamily = selectedFont;
            bottomPreview.style.fontFamily = selectedFont;
        }
    </script>
</body>
</html>
