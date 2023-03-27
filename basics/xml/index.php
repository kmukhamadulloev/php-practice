<?php

require_once './config.php';
require_once './Database.php';
require_once './core.php';

if ($argc === 0) {
    die("USE CONSOLE FOR THIS SCRIPT");
}

$file = $argv[1] ?? './data.xml';

if (!file_exists($file)) {
    die("ERROR: File does not exist");
}

$data = file_get_contents($file);

libxml_use_internal_errors(true);
$data = simplexml_load_string($data);

if (!$data) {
    die("ERROR: XML file is broken");
}

$ids = [];

foreach ($data->offers->offer as $offer) {
    if (!exists((int) $offer->id)) {
        echo insert($offer) ? "DB: {$offer->id} HAS BEEN ADDED : SUCCESS \n" : "DB: {$offer->id} HAS NOT BEEN ADDED : ERROR \n";
    } else {
        echo update((int) $offer->id, $offer) ? "DB: {$offer->id} HAS BEEN UPDATED : SUCCESS \n" : "DB: {$offer->id} HAS NOT BEEN UPDATED : ERROR \n";
    }
    $ids[] = $offer->id;
}

echo remove($ids) ? "DB: ALL UNUSED OFFERS HAS BEEN DELETED : SUCCESS \n" : "DB: ALL UNUSED OFFERS HAS NOT BEEN DELETED : ERROR \n";
