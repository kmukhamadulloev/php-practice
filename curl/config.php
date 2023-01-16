<?php

define("CGET_HEADER", "text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9");
define("CGET_USERAGENT", "Mozilla/5.0 (Macintosh; Intel Mac OS X 11_1_0) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36");

define("DB_HOST", "127.0.0.1");
define("DB_PORT", "3306");
define("DB_NAME", "fl_vsestanki");
define("DB_CHAR", "utf8mb4");
define("DB_TABLE", "items");
define("DB_CONN", 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME.';charset='.DB_CHAR);
define("DB_USER", "disqrl");
define("DB_PASS", "123qwe123");