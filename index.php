<?php

use core\General;


ini_set('memory_limit', '-1');
ini_set('max_execution_time', 300);
define('ROOT', 'https://www.kreuzwort-raetsel.net/');


require_once 'vendor/autoload.php';
$params = require 'config/params.php';


$scraper = new General();
$scraper->parseWholeSite();

