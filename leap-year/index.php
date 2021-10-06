<?php

/**
 * @param int
 * @return bool
 */
function Leap(int $year) : bool
{
    if ($year % 400 === 0) {
        return true;
    } elseif ($year % 100 === 0) {
        return false;
    } elseif ($year % 4 === 0) {
        return true;
    }

    return false;
}

echo Leap(2012);