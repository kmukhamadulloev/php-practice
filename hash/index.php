<?php

$data = "qwerty";

function allHashAlgo(string $data) {
    foreach(hash_algos() as $algo) {
        $result = hash($algo, $data, false);
        $length = strlen($result);
        echo "{$algo} : {$length} : $result</br>";
    }
}

allHashAlgo($data);