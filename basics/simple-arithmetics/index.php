<?php

/**
 * This function calculated two variables using the type of calculation
 * @param int
 * @param int
 * @param string
 * @return string
 */
function Arithmetic(int $a, int $b, string $type) : string {
    switch($type) {
        case '+':
            return $a + $b;
        case '-':
            return $a - $b;
        case '*':
            return $a * $b;
        case '/':
            return $a / $b;
        default:
            return "Неизвестная операция";
    }
}

echo Arithmetic(1, 2, "/");