<?php

require __DIR__."/greentea_php/code_coverage.php";

$buildDir       = BUILD_DIR."/greentea_php";
$m4FragFile     = FRAGMENTS_DIR."/greentea_php.frag.m4";
$m4String       = file_get_contents($m4FragFile);
$m4TargetGen    = $buildDir."/config.m4";
$cFiles         = "";
$includesStr    = "";
$includes       = [GREENTEA_PHP_SRC_DIR];
$replace        = [
    "\$~~FILES~~\$" => &$cFiles,
    "\$~~INCLUDES~~\$" => &$includesStr
];

if (!file_exists($buildDir)) {
    she("cp -asvf ".
        escapeshellarg(GREENTEA_PHP_SRC_DIR)." ".
        escapeshellarg($buildDir)
    );
}

she("cp -asvf ".
    escapeshellarg(APP_DIR)." ".
    escapeshellarg($buildDir)
);

// Scan all greentea C files and copy it to build dir.
recursive_callback_scan(
    GREENTEA_PHP_SRC_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {

        $e = explode(".", $file);
        $e = end($e); // get file extension.
        $edir = explode(GREENTEA_PHP_SRC_DIR, $dir, 2);
        $edir = empty($edir[1]) ? "" : ltrim($edir[1]."/", "/");

        if ($e === "c") {
            $cFiles .= (empty($cFiles) ? "" : " ").$edir.$file;
        }
    }
);

// Scan all app C files and plug it to $cFiles
recursive_callback_scan(APP_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles, $buildDir) {

        $e = explode(".", $file);
        $e = end($e); // get file extension.
        $edir = explode(APP_DIR, $dir, 2);
        $edir = empty($edir[1]) ? "" : ltrim($edir[1]."/", "/");

        if ($e === "c") {
            $cFiles .= " app/".$edir.$file;
        }
    }
);

// Prepare includes file.
foreach ($includes as $k => $v) {
    $includesStr .= "\n  PHP_ADD_INCLUDE(".$v.")";
}

$m4String = str_replace(array_keys($replace),
    array_values($replace), $m4String);

printf("Generating config.m4 file...\n");
$wb = file_put_contents($m4TargetGen, $m4String);
printf("%d bytes are written to %s\n", $wb, $m4TargetGen);

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
