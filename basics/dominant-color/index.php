<?php

/**
 * @param string
 * @return array
 */
function GetDominantColor(string $image) : array
{
    $image = imagecreatefromjpeg($image);

    $image_width = imagesx($image);
    $image_height = imagesy($image);
    $total = $image_width * $image_height;

    $r_total = 0;
    $g_total = 0;
    $b_total = 0;

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
echo "<p><img src='image.jpg' alt='image'></p>";