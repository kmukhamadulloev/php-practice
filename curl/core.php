<?php

function cget($url): string | bool
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_REFERER, $url);

    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($curl, CURLOPT_POST, false);

    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_AUTOREFERER, true);
    curl_setopt($curl, CURLOPT_FAILONERROR, true);
    curl_setopt($curl, CURLOPT_ENCODING, true);

    curl_setopt($curl, CURLOPT_COOKIEJAR, 'cookie.txt');
    curl_setopt($curl, CURLOPT_COOKIEFILE, 'cookie.txt');

    curl_setopt($curl, CURLOPT_HTTPHEADER, [CGET_HEADER]);

    curl_setopt($curl, CURLOPT_USERAGENT, CGET_USERAGENT);

    $content = curl_exec($curl);
    curl_close($curl);
    return $content;
}

function querySelector($content, $query): string
{
    $elements = $content->query($query);
    $innerHTML = "";
    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $child) {
                $innerHTML .= $child->ownerDocument->saveXML($child);
            }
        }
    }

    return $innerHTML;
}
function querySelectorValue($content, $query): string
{
    $elements = $content->query($query);
    $innerHTML = "";
    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $child) {
                $innerHTML .= $child->nodeValue;
            }
        }
    }

    return $innerHTML;
}

function querySelectorAllValue($content, $query): array
{
    $elements = $content->query($query);
    $innerHTML = [];
    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $child) {
                $innerHTML[] = $child->nodeValue;
            }
        }
    }

    return $innerHTML;
}

function querySelectorAll($content, $query): array
{
    $elements = $content->query($query);
    $innerHTML = [];
    if (!is_null($elements)) {
        foreach ($elements as $element) {
            $nodes = $element->childNodes;
            foreach ($nodes as $child) {
                $innerHTML[] = $child->ownerDocument->saveXML($child);
            }
        }
    }

    return $innerHTML;
}

function getFile($link, $title): string
{
    $filename = hash('CRC32', $title . date('Y-m-d h:i:s'));
    $fp = fopen('./images/' . $filename.'.jpg', 'w+');

    $ch = curl_init($link);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10000);
    curl_setopt($ch, CURLOPT_USERAGENT, CGET_USERAGENT);
    curl_exec($ch);

    curl_close($ch);
    fclose($fp);
    return $filename.'.jpg';
}

function saveOutput($array): bool {
    return file_put_contents('./output/' . date('Y-m-d h:i:s') . '.json', json_encode($array));
}

function insertToDatabase($array) {
    $pdo = new Database();
    $stmt = $pdo->query('INSERT INTO items(id, title, category, promo, price, description, images, content)
        VALUES(:id, :title, :category, :promo, :price, :description, :images, :content)', [
        'id' => [
            'value' => $array['id'],
            'type' => PDO::PARAM_STR
        ],
        'title' => [
            'value' => $array['title'],
            'type' => PDO::PARAM_STR
        ],
        'category' => [
            'value' => $array['category'],
            'type' => PDO::PARAM_STR
        ],
        'promo' => [
            'value' => $array['promo'],
            'type' => PDO::PARAM_STR
        ],
        'price' => [
            'value' => $array['price'],
            'type' => PDO::PARAM_STR
        ],
        'description' => [
            'value' => $array['description'],
            'type' => PDO::PARAM_STR
        ],
        'images' => [
            'value' => $array['images'],
            'type' => PDO::PARAM_STR
        ],
        'content' => [
            'value' => $array['content'],
            'type' => PDO::PARAM_STR
        ]
    ], true);
    return $stmt;
}
