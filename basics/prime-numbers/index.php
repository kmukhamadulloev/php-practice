<?php

/**
 * @param int
 * @return bool
 */
function IsPrime(int $a) : bool
{
    $divider = 2;
    while ($a % $divider !== 0) {
        $divider += 1;
    }

    return ($a === $divider);
}

echo IsPrime(37) ? "True" : "False";