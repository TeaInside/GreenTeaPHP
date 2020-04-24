<?php

require __DIR__."/autoload.php";

$buildDir = BUILD_DIR."/greentea_php";
$configM4File = GREENTEA_PHP_SRC_DIR."/config.php.m4";

if (!file_exists($buildDir)) {
    she("cp -asvf ".
        escapeshellarg(GREENTEA_PHP_SRC_DIR)." ".
        escapeshellarg($buildDir)
    );
}

ConfigM4::addFile("greentea_php.c");

// Scan all greentea C files.
recursive_callback_scan(
    GREENTEA_PHP_SRC_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {
        $e = explode(".", $file);
        $e = end($e); // get file extension.
        $edir = explode(GREENTEA_PHP_SRC_DIR, $dir, 2);
        $edir = empty($edir[1]) ? "" : ltrim($edir[1]."/", "/");

        if ($e === "c") {
            ConfigM4::addFile($file);
        }
    }
);

ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR);
ConfigM4::buildConfigM4File($configM4File, $buildDir);
