<?php

$files = [
    dirname(__DIR__).'/tests/Unit/Mocks/MockRequest.php',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        require_once $file;
    }
}
