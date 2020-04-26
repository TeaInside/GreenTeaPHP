<?php

require __DIR__."/build_config.php";

// Load helpers.
require BASEPATH."/src/build_scripts/helpers.php";

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
