<?php

use Majframe\Libs\Exception\MajException;
use Majframe\Web\WebCore;

require_once '../vendor/autoload.php';
require_once '../framework/Libs/Functions/Function.php';

try {
    $web = WebCore::getInstance();
    $web->startWeb();
} catch (MajException $e) {
    echo $e->getMessage();
    echo $e->getCode();
}



