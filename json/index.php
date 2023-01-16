<?php

if (!isset($argv[1])) {
    die("ERROR : No file path!");
}

if (!file_exists($argv[1])) {
    die("ERROR : File does not exist!");
}

$data = file_get_contents($argv[1]);

$categories = json_decode($data, true);

$subcat = [];
$output = [];

foreach ($categories as $category) {
    foreach ($category['subcategories'] as $subcategory) {
        $hash = hash('CRC32', $category['title'] . $subcategory['title']);
        $subcat += [
            $hash => [
            'id' => $hash,
            'title' => $subcategory['title'],
        ]];
    }
    $output[] = [
        'id' => hash('CRC32', $category['title']),
        'title' => $category['title'],
        'subcategories' => $subcat,
    ];
    $subcat = [];
}

file_put_contents('newcategories.json', json_encode($output)) ?? die("Cant save file");
