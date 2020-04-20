<?php

$m4FragFile     = FRAGMENTS_DIR."/greentea_php.frag.m4";
$m4String       = file_get_contents($m4FragFile);
$m4TargetGen    = GREENTEA_PHP_SRC_DIR."/config.m4";
$cFiles         = "";

$replace        =
[
    "\$~~FILES~~\$" => &$cFiles
];

// Scan all C files.
recursive_callback_scan(
    GREENTEA_PHP_SRC_DIR,
    function (string $file, string $dir, int $index) use (&$cFiles) {

        $e = explode(".", $file);
        $e = end($e); // get file extension.
        $dir = explode(".", GREENTEA_PHP_SRC_DIR, 2);
        $dir = $dir[1] ?? "";

        if ($e === "c") {
            $cFiles .= ltrim($dir."/".$file, "/")." ";
        }
    }
);

$m4String = str_replace(array_keys($replace),
    array_values($replace), $m4String);

printf("Generating config.m4 file...\n");
$wb = file_put_contents($m4TargetGen, $m4String);
printf("%d bytes are written to %s\n", $wb, $m4TargetGen);

