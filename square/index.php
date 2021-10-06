<?php

/**
 * @param int
 * @return array
 */
function Square(int $side) : array
{
    $diagonal = sqrt(2) * $side;
    $square = pow($side, 2);
    $perimeter = 4 * $side;

    return array($perimeter, $square, $diagonal);
}

$result = Square(5);

echo "Периметр: {$result[0]}, Площадь: {$result[1]}, Диагональ: {$result[2]}";