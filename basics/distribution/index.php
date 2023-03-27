<?php

if (file_exists($argv[1])) {
    $data = file_get_contents($argv[1]);
    $data = explode(PHP_EOL, $data);
} else {
    showHelp();
}

$plus = "";
$minus = "";

if ($data[0] == "") {
    echo "File is empty";
    die;
}

foreach($data as $line => $value) {
    $items = explode(' ', $value);
    if (count($items) == 2) {
        switch($argv[2]) {
            case '*':
            case 'multiply':
                $result = ((int)$items[0]) * ((int)$items[1]);
                break;
            case '/':
            case 'devide':
                $result = ((int)$items[0]) / ((int)$items[1]);
                break;
            case '+':
            case 'add':
                $result = ((int)$items[0]) + ((int)$items[1]);
                break;
            case '-':
            case 'subtract':
                $result = ((int)$items[0]) - ((int)$items[1]);
                break;
            default:
                showHelp();
        }

        if ($result > 0) {
            $plus = ($plus == "") ? $plus . strval($result) : $plus . PHP_EOL . strval($result);
        } else {
            $minus = ($minus == "") ? $minus . strval($result) : $minus . PHP_EOL . strval($result);
        }

    } else {
        echo "Check input line $line";
    }
}

file_put_contents('plus.txt', $plus);
file_put_contents('minus.txt', $minus);

function showHelp() {
    echo "Incorrect syntax\nThere have to be 2 arguments:\nfilepath like test.txt or /etc/file/test.txt\noption like (* or multiply, / or devide, + or add, - or subtract)\nphp index.php filepath option\nexample: php index.php test.txt +";
    die;
}