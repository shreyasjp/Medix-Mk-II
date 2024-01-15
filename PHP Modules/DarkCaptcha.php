<?php
session_start();

// Generate CAPTCHA
/* if (mt_rand(0, 1)) {
    $captchaData = generateText();
} else {
    $captchaData = generateMath();
} */

$captchaData = generateText();

$expectedResult = $captchaData['expectedResult'];
$a = $captchaData['a'];
$b = $captchaData['b'];
$c = $captchaData['c'];
$d = $captchaData['d'];

$_SESSION['captcha_expected_result'] = $expectedResult;

// Create image
$imageWidth = 175;
$imageHeight = 56;
$image = imagecreatetruecolor($imageWidth, $imageHeight);

// Background color
$backgroundColor = imagecolorallocate($image, 47, 47, 47); // Dark gray (#2f2f2f)
imagefill($image, 0, 0, $backgroundColor);

// Text color
$textColor = imagecolorallocate($image, 242, 242, 242); // Light gray (#f2f2f2)

// Specify the path to your TrueType font file
$fontFiles = [
    '../Data/Fonts/GothamLight.ttf'
];

$fontFile = $fontFiles[array_rand($fontFiles)];

// Randomize distortions
$distortedImage = applyDistortion($image, $imageWidth, $imageHeight);

// Draw CAPTCHA text on the distorted image using the custom font
$fontSize = 25; // Adjust font size as needed
$text = "{$a} {$b} {$c} {$d}";
drawTextWithVariations($distortedImage, $text, $fontFile, $textColor, $fontSize, $imageWidth, $imageHeight);

// Add random lines to the distorted image
$lineCount = 15; // Adjust the number of lines as needed
addRandomLines($distortedImage, $imageWidth, $imageHeight, $lineCount);

// Add noise to the distorted image
addNoise($distortedImage, $imageWidth, $imageHeight);

// Add grid lines to the distorted image
addGridLines($distortedImage, $imageWidth, $imageHeight);

// Output the image as PNG
header('Content-type: image/png');
imagepng($distortedImage);
imagedestroy($distortedImage);

// Function to apply distortions to the image
function applyDistortion($image, $imageWidth, $imageHeight)
{
    $distortedImage = imagecreatetruecolor($imageWidth, $imageHeight);
    $backgroundColor = imagecolorallocate($distortedImage, 47, 47, 47); // Dark gray (#2f2f2f)
    imagefill($distortedImage, 0, 0, $backgroundColor);

    for ($x = 0; $x < $imageWidth; $x++) {
        for ($y = 0; $y < $imageHeight; $y++) {
            $srcX = $x + (int) (sin($y / $imageHeight * 2 * M_PI) * 5);
            $srcY = $y + (int) (cos($x / $imageWidth * 2 * M_PI) * 5);
            if ($srcX >= 0 && $srcX < $imageWidth && $srcY >= 0 && $srcY < $imageHeight) {
                $pixel = imagecolorat($image, $srcX, $srcY);
                imagesetpixel($distortedImage, $x, $y, $pixel);
            }
        }
    }

    return $distortedImage;
}

// Function to draw CAPTCHA text with variations
function drawTextWithVariations($image, $text, $fontFile, $color, $size, $imageWidth, $imageHeight)
{
    $variationColor = imagecolorallocate($image, 255, 255, 255); // Light gray (#f2f2f2)
    $characterCount = strlen($text);
    $spacing = mt_rand(15, 20); // Adjust spacing between characters as needed
    $fontFiles = [
        '../Data/Fonts/GothamBold.ttf',
        '../Data/Fonts/GothamMedium.ttf'
    ];

    // Loop through each character
    for ($i = 0; $i < $characterCount; $i++) {
        $character = $text[$i];
        $variationAngle = mt_rand(-7, 7); // Variation angle for each character

        // Calculate the position for each character
        $x = $i * $spacing + 15;
        $y = 40;

        if ($character == '-') {
            $fontFile = '../Data/Fonts/GothamBold.ttf';
        } else {
            $fontFile = $fontFiles[array_rand($fontFiles)];
        }
        // Draw each character with variations
        imagettftext($image, $size, $variationAngle, $x, $y, $variationColor, $fontFile, $character);
    }
}

// Function to add random lines to the image
function addRandomLines($image, $imageWidth, $imageHeight, $lineCount)
{
    $lineColor = imagecolorallocate($image, 151, 151, 151); // Black

    for ($i = 0; $i < $lineCount; $i++) {
        $startX = mt_rand(0, $imageWidth);
        $startY = mt_rand(0, $imageHeight);
        $endX = mt_rand(0, $imageWidth);
        $endY = mt_rand(0, $imageHeight);

        imageline($image, $startX, $startY, $endX, $endY, $lineColor);
    }
}

// Function to add noise to the image
function addNoise($image, $imageWidth, $imageHeight)
{
    $noiseLevel = 40; // Adjust noise level as needed

    for ($x = 0; $x < $imageWidth; $x++) {
        for ($y = 0; $y < $imageHeight; $y++) {
            $noise = (int) (mt_rand(-$noiseLevel, $noiseLevel));
            $color = imagecolorat($image, $x, $y) & 0xFF;
            $color += $noise;
            if ($color < 0) {
                $color = 0;
            } elseif ($color > 255) {
                $color = 255;
            }
            $color = imagecolorallocate($image, $color, $color, $color);
            imagesetpixel($image, $x, $y, $color);
        }
    }
}

// Function to add grid lines to the image
function addGridLines($image, $imageWidth, $imageHeight)
{
    $gridColor = imagecolorallocate($image, 81, 81, 81); // Black

    // Draw vertical grid lines
    for ($x = 0; $x < $imageWidth; $x += 5) {
        imageline($image, $x, 0, $x, $imageHeight, $gridColor);
    }

    // Draw horizontal grid lines
    for ($y = 0; $y < $imageHeight; $y += 7) {
        imageline($image, 0, $y, $imageWidth, $y, $gridColor);
    }
}

// Random Math generation
function generateMath()
{
    $a = mt_rand(1, 10);
    $b = mt_rand(1, 10);
    $operators = ['+', '-', '*'];
    $c = $operators[array_rand($operators)];
    $d = '=';
    if ($c === '+') {
        $expectedResult = $a + $b;
    } elseif ($c === '-') {
        $b = mt_rand(0, $a);
        $expectedResult = $a - $b;
    } elseif ($c === '*') {
        $c = 'x';
        $expectedResult = $a * $b;
    }
    return [
        'a' => $a,
        'b' => $c,
        'c' => $b,
        'd' => $d,
        'expectedResult' => $expectedResult
    ];
}

// Random text generation
function generateText()
{
    $letters = "abcdefghjkmnpqrstz123456789ABCDEFGHJKMNPQRSTVWXYZ";
    $letters = str_split($letters);
    $a = $letters[array_rand($letters)];
    $b = $letters[array_rand($letters)];
    $c = $letters[array_rand($letters)];
    $d = $letters[array_rand($letters)];
    $expectedResult = $a . $b . $c . $d;
    return [
        'a' => $a,
        'b' => $b,
        'c' => $c,
        'd' => $d,
        'expectedResult' => $expectedResult
    ];
}