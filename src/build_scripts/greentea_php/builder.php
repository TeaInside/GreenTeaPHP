<?php

require __DIR__."/autoload.php";

$buildDir = BUILD_DIR."/greentea_php";
$configM4File = GREENTEA_PHP_SRC_DIR."/config.php.m4";

if (!file_exists($buildDir)) {
    she("cp -asvf ".
        escapeshellarg(GREENTEA_PHP_SRC_DIR)." ".
        escapeshellarg($buildDir));
}

ConfigM4::addFile("greentea_php.c");

// Scan all greentea C files.
recursive_callback_scan(
    GREENTEA_PHP_SRC_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {
        if ($file === "greentea_php.php.c") {
            return;
        }

        $edir = explode(GREENTEA_PHP_SRC_DIR, $dir, 2);
        $edir = isset($edir[0]) ? trim($edir[1], "/")."/" : "";
        if (preg_match("/(.+)\.php\.c$/", $file, $m)) {
            $targetDir = $buildDir."/".$edir;
            $targetFile = $m[1].".compiled.php.c";
            is_dir($buildDir) or mkdir($buildDir);
            is_dir($targetDir) or mkdir($targetDir);
            PHPClass::compile($dir."/".$file, $targetDir, $targetFile);

            ConfigM4::addFile($edir.$targetFile);
        } else if (preg_match("/.+\.c$/", $file)) {
            ConfigM4::addFile($edir.$file);
        }
    }
);

PHPClass::compile(GREENTEA_PHP_SRC_DIR."/greentea_php.php.c", $buildDir, "greentea_php.c");
ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR);
ConfigM4::buildConfigM4File($configM4File, $buildDir);

she("cp -asvf ".
    escapeshellarg(APP_DIR)." ".
    escapeshellarg($buildDir));

// Scan all greentea C files.
recursive_callback_scan(
    APP_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {
        if ($file === "greentea_php.php.c") {
            return;
        }

        $edir = explode(APP_DIR, $dir, 2);
        $edir = isset($edir[0]) ? rtrim($edir[1], "/")."/" : "";

        if (preg_match("/(.+)\.php\.c$/", $file, $m)) {
            $targetDir = $buildDir."/app/".$edir;
            $targetFile = $m[1].".compiled.php.c";
            is_dir($buildDir) or mkdir($buildDir);
            is_dir($targetDir) or mkdir($targetDir);

            PHPClass::compile($dir."/".$file, $targetDir, $targetFile);
        }
    }
);


shechdir($buildDir);
if (!file_exists($buildDir."/.phpize.lock")) {
    she("phpize");
    touch($buildDir."/.phpize.lock");
}

if (!file_exists($buildDir."/.configure.lock")) {
    she("./configure");
    touch($buildDir."/.configure.lock");
}

she("make");
she("cp -vf ".
    escapeshellarg($buildDir."/modules/greentea.so")." ".
    escapeshellarg(MODULES_DIR)
);