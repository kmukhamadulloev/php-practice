<?php

/**
 * @param string
 * @param string
 * @param float
 * @return void
 */
function setWatermark(string $image, string $watermark, float $alpha = 0.5) : void
{
    $image = imagecreatefromjpeg($image) or die('Something is wrong with $IMAGE');
    $watermark = imagecreatefrompng($watermark) or die('Somethign is wrong with $WATERMARK');
    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);

    if ($alpha > 1 || $alpha < 0) die('Something is wrong with ALPHA variable');

    imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $alpha);

    $image_width = imagesx($image);
    $image_height = imagesy($image);

    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    imagecopy($image, $watermark, $image_width - $watermark_width - 10, $image_height - $watermark_height - 10, 0, 0, $watermark_width, $watermark_height);

    imagejpeg($image, 'image-with-watermark.jpg') or die("Something is wrong with SAVING RESULT");
    imagedestroy($watermark);
    imagedestroy($image);
}

setWatermark('image.jpg', 'watermark.png', 0.7);

echo "<img src='./image-with-watermark.jpg' />";