<?php

require __DIR__."/config/build.php";

// Load helpers.
require BASEPATH."/src/helpers/build.php";

$host = "0.0.0.0";
$port = 8000;

she(escapeshellarg(PHP_BINARY).
    " -d extension=".
    escapeshellarg(MODULES_DIR."/greentea.so").
    " -S ".
    escapeshellarg($host).":".
    escapeshellarg($port)." -t ".
    escapeshellarg(PUBLIC_DIR)
);
