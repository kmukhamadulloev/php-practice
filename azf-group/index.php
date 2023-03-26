<?php

require_once(__DIR__ . '/Parser.php');

$url = "https://dreamicon.ru"; // set the link

$data = Parser::parse($url); // geting data from specific url

foreach($data as $key => $value) {
    echo "{$key} : {$value}\n"; // showing data like a : 12 means that on that specific url our parser got 12 <a ...></a> tags
}