<?php

function GetDominantColor($image) : array
{
    $image = imagecreatefromjpeg($image);

    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $total = $image_width * $image_height;

    for ($x = 0; $x <= $image_width; $x++) {
        for ($y = 0; $y <= $image_height; $y++) {
            $rgb = imagecolorat($image, $x, $y);
            $r = ($rgb >> 16) & 0xFF;
            $g = ($rgb >> 8) & 0xFF;
            $b = $rgb & 0xFF;

            $r_total += $r;
            $g_total += $g;
            $b_total += $b;
        }
    }

    $red = round($r_total / $total);
    $green = round($g_total / $total);
    $blue = round($b_total / $total);

    $rhex = dechex(round($r_total / $total));
    $ghex = dechex(round($g_total / $total));
    $bhex = dechex(round($b_total / $total));

    return [
        'rgb' => [$red, $green, $blue],
        'hex' => "#{$rhex}{$ghex}{$bhex}"
    ];
}

$color = GetDominantColor('image.jpg');

echo "<input type='color' value='{$color['hex']}' /> HEX: {$color['hex']} | Red: {$color['rgb'][0]} Green: {$color['rgb'][1]} Blue: {$color['rgb'][2]}";

/*$image = 'image.jpg';

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
var_dump($color);
echo "<br/>";
// replaceColor($image, $color, $replace); */