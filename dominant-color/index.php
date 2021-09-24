<?php
$image = 'img-test.jpg';
$imageResult = 'img-result.jpg';

$replace = array(
    'red' => 255,
    'green' => 255,
    'blue' => 255
);

function getDominant($image) {
    $image = imagecreatefromjpeg($image) or die("Problem with source");;
    $width = imagesx($image);
    $height = imagesy($image);
    $pixel = imagecreatetruecolor(1, 1);
    imagecopyresampled($pixel, $image, 0, 0, 0, 0, 1, 1, $width, $height);
    $rgb = imagecolorat($pixel, 0, 0);
    $color = rgb_to_array($rgb);
    return $color;
}

function replaceColor($image, $color, $replace) {
    $image = imagecreatefromjpeg($image) or die("Problem with source");
    $width = imagesx($image);
    $height = imagesy($image);

    // var_dump($width, $height);

    $output = ImageCreateTrueColor($width, $height) or die('Problem In Creating image');

    for ($x = 0; $x < $width; $x++) {
        for ($y = 0; $y < $height; $y++) {
            if ($y == 853 && $x == 1280) {
                exit;
            }

            $pixel = imagecolorat($image, $x, $y);
            $rgb = rgb_to_array($pixel);

            if ($rgb['red'] == $color['red'] || $rgb['green'] == $color['green'] || $rgb['blue'] == $color['blue']) {
                $rgb['red'] = $replace['red'];
                $rgb['green'] = $replace['green'];
                $rgb['blue'] = $replace['blue'];
                // echo "True ";
            }

            imagesetpixel($output, $x, $y, imagecolorallocate($output, $rgb['red'], $rgb['green'], $rgb['blue']));
        }
    }

    imagejpeg($output, 'img-result.jpg') or die("Cant save image");
    imagedestroy($output);
}

function rgb_to_array($rgb) {
    $p['red'] = ($rgb >> 16) & 0xFF;
    $p['green'] = ($rgb >> 8) & 0xFF;
    $p['blue'] = $rgb & 0xFF;

    return $p;
}

$color = getDominant($image);

replaceColor($image, $color, $replace);
echo "<img src='{$image}' alt='test image' width='600' />";
echo "<img src='{$imageResult}' alt='test image' width='600' />";
