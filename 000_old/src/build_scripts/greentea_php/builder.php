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
        $edir = isset($edir[0]) ? ltrim(trim($edir[1], "/")."/", "/") : "";
        if (preg_match("/(.+)\.php\.(c|cc|cpp|cxx)$/", $file, $m)) {
            $targetDir = $buildDir."/".$edir;
            $targetFile = $m[1].".compiled.php.".$m[2];
            is_dir($buildDir) or mkdir($buildDir);
            is_dir($targetDir) or mkdir($targetDir);
            PHPClass::compile($dir."/".$file, $targetDir, $targetFile);

            if (!in_array($m[2], ["hpp", "h", "hxx"])) {
                ConfigM4::addFile($edir.$targetFile);
            }
        } else if (preg_match("/.+\.c$/", $file)) {
            ConfigM4::addFile($edir.$file);
        }
    }
);

ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR);
ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR."/include");
ConfigM4::buildConfigM4File($configM4File, $buildDir);

she("cp -asvf ".
    escapeshellarg(APP_DIR)." ".
    escapeshellarg($buildDir));

she("cp -asvf ".
    escapeshellarg(ROUTES_DIR)." ".
    escapeshellarg($buildDir));

// Scan all greentea C files.
recursive_callback_scan(
    APP_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {
        $edir = explode(APP_DIR, $dir, 2);
        $edir = isset($edir[0]) ? ltrim(trim($edir[1], "/")."/", "/") : "";

        if (preg_match("/(.+)\.php\.(c|cc|cpp|cxx)$/", $file, $m)) {
            $targetDir = $buildDir."/app/".$edir;
            $targetFile = $m[1].".compiled.php.".$m[2];
            is_dir($buildDir) or mkdir($buildDir);
            is_dir($targetDir) or mkdir($targetDir);

            PHPClass::compile($dir."/".$file, $targetDir, $targetFile, true);
        }
    }
);

// Scan all greentea C files.
recursive_callback_scan(
    ROUTES_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {
        $edir = explode(APP_DIR, $dir, 2);
        $edir = isset($edir[0]) ? ltrim(trim($edir[1], "/")."/", "/") : "";

        if (preg_match("/(.+)\.php\.(c|cc|cpp|cxx)$/", $file, $m)) {
            $targetDir = $buildDir."/routes/".$edir;
            $targetFile = $m[1].".compiled.php.".$m[2];
            is_dir($buildDir) or mkdir($buildDir);
            is_dir($targetDir) or mkdir($targetDir);

            PHPClass::compile($dir."/".$file, $targetDir, $targetFile, true);
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

ConfigM4::plugToMakefile($buildDir);
PHPClass::compile(GREENTEA_PHP_SRC_DIR."/greentea_php.php.c", $buildDir, "greentea_php.c");

she("make");
she("cp -vf ".
    escapeshellarg($buildDir."/modules/greentea.so")." ".
    escapeshellarg(MODULES_DIR)
);