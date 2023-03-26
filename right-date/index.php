<?php

/**
 * @param int
 * @param int
 * @param int
 * @return bool
 */
function DoesDateExist(int $day, int $month, int $year) : bool
{
    if (($day > 0) && ($day < 32) && (in_array($month, [1, 3, 5, 7, 8, 10, 12]))) return true;
    if (($day > 0) && ($day < 31) && (in_array($month, [4, 6, 9, 11]))) return true;
    if (($day > 0) && ($day < 29) && $month === 2) return true;
    if ((($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0) && $month === 2 && $day === 29)
        return true;
    else
        return false;
}

echo DoesDateExist(29, 2, 2013) ? "Дата есть в календаре" : "Такой даты нет";