<?php

require __DIR__."/autoload.php";

$constants = [
  "APP_DIR",
  "BASEPATH",
  "BUILD_DIR",
  "GREENTEA_PHP_SRC_DIR"
];
foreach ($constants as $constant) {
  if (!defined($constant)) {
    echo $constant." is not defined!\n";
    exit(1);
  }
}

$buildDir = BUILD_DIR."/greentea_php";

if ((!is_dir($buildDir)) && (!mkdir($buildDir))) {
  echo "Cannot create greentea_php build dir: {$buildDir}!\n";
  exit(1);
}

recursive_callback_scan(GREENTEA_PHP_SRC_DIR,
  function (string $file, string $dir, int $i) use ($buildDir) {
    if ($file === "greentea_php.php.c") {
      return;
    }

    $edir = explode(GREENTEA_PHP_SRC_DIR, $dir);
    $edir = isset($edir[1]) ? ltrim(trim($edir[1], "/")."/", "/") : "";

    if (preg_match("/(.+)\.php\.(.{1,5})/", $file, $m)) {
      $sourceFile = $dir."/".$file;
      $targetFile = $buildDir.$edir;
      mkdirp($edir);

      PHPClass::compile($sourceFile, $targetFile, $addToM4);
    }
  }
);