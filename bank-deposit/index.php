<?php

/**
 * @param int
 * @param int
 * @return int
 */

function Bank(int $a, int $year) : int
{
    for ($i = 0; $i < $year; $i++) {
        $a += $a * ((1 / 100) * 14);
    }

    return $a;
}

echo Bank(1000, 2);