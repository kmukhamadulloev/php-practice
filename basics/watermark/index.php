<?php

/**
 * @param string
 * @param string
 * @param float
 * @return void
 */
function setWatermark(string $image, string $watermark, string $filename, float $alpha = 0.5) : void
{
    if (!($image = imagecreatefromjpeg($image))) throw new Exception('Somethign is wrong with $WATERMARK', 1);
    if (!($watermark = imagecreatefrompng($watermark))) throw new Exception('Somethign is wrong with $WATERMARK', 1);

    imagealphablending($watermark, false);
    imagesavealpha($watermark, true);

    if ($alpha > 1 || $alpha < 0) throw new Exception('Something is wrong with ALPHA variable', 1);

    imagefilter($watermark, IMG_FILTER_COLORIZE, 0, 0, 0, 127 * $alpha);

    $image_width = imagesx($image);
    $image_height = imagesy($image);

    $watermark_width = imagesx($watermark);
    $watermark_height = imagesy($watermark);

    imagecopy($image, $watermark, $image_width - $watermark_width - 10, $image_height - $watermark_height - 10, 0, 0, $watermark_width, $watermark_height);

    if (!(imagejpeg($image, "$filename.jpg"))) throw new Exception('Something is wrong with SAVING RESULT', 1);
    imagedestroy($watermark);
    imagedestroy($image);
}

setWatermark('image.jpg', 'watermark.png', 'test',0.7);

echo "<img src='./image-with-watermark.jpg' />";