<?php

use Majframe\Web\WebCore;

require_once '../vendor/autoload.php';

WebCore::startWeb();

echo '<br><br><br><h1 style="color: red">' .  memory_get_peak_usage()/1024 . 'KB</h1>';



