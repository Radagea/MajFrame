<?php

use Majframe\Web\WebCore;

require_once '../vendor/autoload.php';

WebCore::startWeb();


echo json_encode(['peak_memory_usage' => memory_get_peak_usage()/1024 . 'KB']);



