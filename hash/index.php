<?php

$data = "qwerty";

/**
 * @param string
 * @return void
 */
function allHashAlgo(string $data) : void
{
    foreach(hash_algos() as $algo) {
        $result = hash($algo, $data, false);
        $length = strlen($result);
        echo "{$algo} : {$length} : $result</br>";
    }
}

allHashAlgo($data);