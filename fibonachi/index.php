<?php

$fibArray = [3279, 920, 4181, 8, 337, 13, 918, 4923, 4448, 8, 4756, 4012, 7467, 89, 21, 2400, 4409, 6005, 3172, 55, 5, 6367, 8, 9970, 144, 1, 4360, 407, 7010, 9160, 7149, 9038, 9196, 8625, 662, 1597, 21, 2592, 1597, 5424, 2584, 2937, 1597, 9835, 7960, 2254, 3531, 8034, 9393, 807, 3225, 6765, 399, 3230, 34, 153, 2, 3980, 2093, 9238, 2326, 6453, 89, 4606, 3413, 3, 9950, 2098, 8579, 4914, 7204, 8875];

function isSquare($num) {
    return $num > 0 && fmod(sqrt($num), 1) === 0.0;
}

function isFib($num) {
    return (isSquare(5 * ($num * $num) - 4) || isSquare(5 * ($num * $num) + 4));
}

function sumFib($array = []) {
    if (!empty($array)) {
        $summ = 0;
        foreach($array as $num) {
            if (isFib($num)) {
                $summ += $num;
            }
        }
        return $summ;
    }
}

echo sumFib($fibArray);