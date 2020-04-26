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

    // Skip main and m4 files.
    if ($file === "greentea_php.php.c" || $file === "config.php.m4")
      return;

    $edir     = explode(GREENTEA_PHP_SRC_DIR, $dir);
    $edir     = isset($edir[1]) ? trim($edir[1], "/")."/" : "/";
    $addToM4  = true;

    if (preg_match("/^(.+)\.php\.(.{1,5})$/", $file, $m)) {
      $sourceFile = $dir."/".$file;
      $targetFile = $buildDir."/".$edir.$m[1].".compiled.".$m[2];
      mkdirp($buildDir."/".$edir);
      PHPClass::compile($sourceFile, $targetFile, $addToM4);
    } else if (preg_match("/^.+\.(c|cpp)$/", $file, $m)) {
      ConfigM4::addFile($edir.$file);
    }
  }
);