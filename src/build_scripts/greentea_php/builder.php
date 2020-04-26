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

$appDir   = APP_DIR."/cpp";
$buildDir = BUILD_DIR."/greentea_php";

if ((!is_dir($buildDir)) && (!mkdir($buildDir))) {
  echo "Cannot create greentea_php build dir: {$buildDir}!\n";
  exit(1);
}

// Add main files to m4.
ConfigM4::addFile("app_entry.compiled.cpp");
ConfigM4::addFile("greentea_php.compiled.c");
ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR);
ConfigM4::addIncludePath(GREENTEA_PHP_SRC_DIR."/include");

/**
 * GreenTea core generator.
 */
recursive_callback_scan(GREENTEA_PHP_SRC_DIR,
  function (string $file, string $dir, int $i) use ($buildDir) {

    // Skip main and m4 files.
    if (
      $file === "greentea_php.php.c"  ||
      $file === "config.php.m4"       ||
      $file === "app_entry.php.cpp"
    )
      return;

    $edir     = explode(GREENTEA_PHP_SRC_DIR, $dir, 2);
    $edir     = isset($edir[1]) ? trim($edir[1], "/")."/" : "/";

    if (preg_match("/^(.+)\.php\.(.{1,5})$/", $file, $m)) {
      $sourceFile = $dir."/".$file;
      $targetFile = $buildDir."/".$edir.$m[1].".compiled.".$m[2];
      mkdirp($buildDir."/".$edir);
      PHPClass::compile($sourceFile, $targetFile);
      ConfigM4::addFile($edir.$m[1].".compiled.".$m[2]);
    } else if (preg_match("/^.+\.(c|cpp)$/", $file, $m)) {
      mkdirp($buildDir."/".$edir);
      link($dir."/".$file, $buildDir."/".$edir.$file);
      ConfigM4::addFile($edir.$file);
    }
  }
);

/**
 * GreenTea core generator.
 */
recursive_callback_scan($appDir,
  function (string $file, string $dir, int $i) use ($buildDir, $appDir) {

    $buildDir = rtrim($buildDir, "/")."/app";
    $edir     = explode($appDir, $dir, 2);
    $edir     = isset($edir[1]) ? trim($edir[1], "/")."/" : "/";

    if (preg_match("/^(.+)\.php\.(.{1,5})$/", $file, $m)) {
      $sourceFile = $dir."/".$file;
      $targetFile = $buildDir."/".$edir.$m[1].".compiled.".$m[2];
      mkdirp($buildDir."/".$edir);
      PHPClass::compile($sourceFile, $targetFile);
    } else if (preg_match("/^.+\.(c|cpp)$/", $file, $m)) {
      $targetFile = $buildDir."/".$edir.$file;
      link($targetFile, $dir."/".$file);
    }
    isset($targetFile) and PHPClass::addAppFile($targetFile);
  }
);

PHPClass::compile(
  GREENTEA_PHP_SRC_DIR."/greentea_php.php.c",
  $buildDir."/greentea_php.compiled.c"
);
PHPClass::compile(
  GREENTEA_PHP_SRC_DIR."/app_entry.php.cpp",
  $buildDir."/app_entry.compiled.cpp"
);
ConfigM4::generate(
  GREENTEA_PHP_SRC_DIR."/config.php.m4",
  $buildDir."/config.m4"
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