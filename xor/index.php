<?php

function XORF(string $string, string $key) : string
{
    for ($i = 0; $i < strlen($string); $i++)
        $string[$i] = ($string[$i] ^ $key[$i % strlen($key)]);

    return $string;    
}

echo XORF('qwerty', '12345') . '</br>';
echo XORF(XORF('qwerty', '12345'), '12345');