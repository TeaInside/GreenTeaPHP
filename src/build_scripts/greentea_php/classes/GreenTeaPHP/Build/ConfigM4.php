<?php

namespace GreenTeaPHP\Build;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @package \GreenTeaPHP\Build
 * @version 0.0.1
 */
final class ConfigM4
{
  /**
   * @var array
   */
  private static $files = [];

  /**
   * @var array
   */
  private static $includePaths = [];

  /**
   * @param string $file
   * @return void
   */
  public static function addFile(string $file): void
  {
    self::$files[] = $file;
  }

  /**
   * @param string $path
   * @return void
   */
  public static function addIncludePath(string $path): void
  {
    self::$includePaths[] = $path;
  }

  /**
   * @param void
   */
  public static function generateIncludePath(): void
  {
    $r = "";
    foreach (self::$includePaths as $k => $v) {
      $r .= "  PHP_ADD_INCLUDE({$v})\n";
    }
    echo $r;
  }

  /**
   * @return string
   */
  public static function phpNewExt(): void
  {
    $files = "";
    foreach (self::$files as $k => $v) {
      $files .= $v." ";
    }
    $files = trim($files);
    echo "  PHP_NEW_EXTENSION(greentea, {$files}, \$ext_shared,, \"-Wall\")";
  }

  /**
   * @param string $source
   * @param string $targetFile
   */
  public static function generate(string $source, string $targetFile): void
  {
    ob_start();
    require $source;
    $out = ob_get_clean();
    $curHash = md5($out);
    $oldHash = file_exists($targetFile) ? md5_file($targetFile) : null;

    if ($curHash !== $oldHash) {
      file_put_contents($targetFile, $out);
    }
  }
}
