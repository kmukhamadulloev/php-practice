<?php

/**
 * @param int
 * @return string
 */
function Season(int $month) : string
{
    switch($month) {
        case 1:
        case 2:
        case 12:
            return 'Зима';
        case 3:
        case 4:
        case 5:
            return 'Весна';
        case 6:
        case 7:
        case 8:
            return 'Лето';
        case 9:
        case 10:
        case 11:
            return 'Осень';
        default:
            return 'Нет такого месяца';
    }
}

echo Season(12);