<?php

require_once "config.php";
require_once "core.php";
require_once "Database.php";

$url = "";
$useFile = false;
$urlFile = "";
$dataBase = false;
$setOutput = false;

$items = [];

if (!$argv) {
    die("Use terminal for this script, or check README file");
}

if (count($argv) == 1) {
    help();
}

foreach ($argv as $key => $value) {
    switch ($value) {
        case '-U':
            setUrl($argv[$key + 1]);
            break;
        case '-A':
            setUrlFile($argv[$key + 1]);
            break;
        case '-M':
            addToDB();
            break;
        case '-O':
            output();
            break;
        case '-H':
            help();
            break;
    }
}

function setUrl(string $link): void
{
    global $url;
    if (!filter_var($link, FILTER_VALIDATE_URL)) {
        die("{$link} : URL is not valid \n");
    }
    $url = $link;
}

function setUrlFile(string $path): void
{
    global $useFile, $urlFile;

    if (!file_exists($path)) {
        die('File doesnt exist');
    }

    $handle = fopen($path, "r");
    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = preg_replace("@\n@", "", $line);
            if (!filter_var($line, FILTER_VALIDATE_URL)) {
                die("{$line} : URL is not valid \n");
            }
        }
    }
    fclose($handle);

    $useFile = true;
    $urlFile = $path;
}

function addToDB(): void
{
    global $dataBase;
    $dataBase = true;
}

function output(): void
{
    global $setOutput;
    $setOutput = true;
}

function help(): void
{
    echo "\nSimple KVS item downloader \n";
    echo "========================== \n";
    echo "-U : Set single URL link \n";
    echo "-A : Set links file path \n";
    echo "-O : Set output (json) \n";
    echo "-M : Insert data into Database (setup config.php file) \n";
    echo "========================== \n";
    echo "php index.php -U 'https://kvs.ru/catalog/item_01' -O -M : This example will get data from url and make an output json file, and add all it to database \n";
    echo "php index.php -A ./urlfile.txt -O -M                    : This example will get urls from specific file then make an output json file, and add all it to database \n";
    echo "========================== \n \n";
    die();
}

function down($link): array
{
    $dom = new DOMDocument();
    $webdata = cget($link) ?: die("Couldnt download webpage, check internet connection!\n");
    libxml_use_internal_errors(true);
    $dom->loadHTML($webdata);
    $pathx = new DOMXPath($dom);

    $title = querySelector($pathx, '//*[@id="product"]/article/h2');
    $id = hash('CRC32', $title);
    $category = hash("CRC32", querySelectorValue($pathx, '//*[@id="breadcrumbs"]/a[2]') . ' - ' . querySelectorValue($pathx, '//*[@id="breadcrumbs"]/a[3]'));
    $price = querySelectorValue($pathx, '//*[@id="price"]/div[1]');
    $description = querySelector($pathx, '//div[@id="excerpt"]');
    $imageTags = array_filter(querySelectorAll($pathx, '//*[@id="product_image"]'), fn($value) => !is_null($value) && trim($value) !== "");
    $images = [];

    foreach ($imageTags as $tag) {
        $img = new SimpleXMLElement($tag);
        $images[] = getFile($img['src'], $title);
        $img = null;
    }

    $content = str_replace(["\r", "\n"], '', querySelector($pathx, '//div[@id="product_content"]'));

    $dom = null;

    return [
        "id" => $id,
        "title" => trim($title),
        "category" => $category,
        "promo" => $images[0],
        "price" => $price,
        "description" => trim($description),
        "images" => implode('-', $images),
        "content" => $content,
    ];
}

if ($useFile) {
    $handle = fopen($urlFile, "r");

    if ($handle) {
        while (($line = fgets($handle)) !== false) {
            $line = preg_replace("@\n@", "", $line);
            $item = down($line);

            echo 'CURL: ' . $item['title'] . " : success\n" ?? $line . " :  failure\n";

            if ($dataBase) {
                echo (insertToDatabase($item)) ? "DB: {$item['title']} : SUCCESS \n" : "DB: {$item['title']} : ERROR \n";
            }

            array_push($items, $item);
        }
    }

    fclose($handle);
} else {
    $item = down($url);
    array_push($items, $item);
}

if ($setOutput) {
    echo (saveOutput($items)) ? "OUTPUT: File has been saved" : "OUTPUT: File cannot be saved";
}