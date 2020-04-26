<?php

namespace GreenTeaPHP\Build;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @package \GreenTeaPHP\Build
 * @version 0.0.1
 */
final class CPPClass
{
  /**
   * @var string
   */
  private $namespace;

  /**
   * @var string
   */
  private $classname;

  /**
   * @var string
   */
  private $file;

  /** 
   * @param string $namespace
   * @param string $classname
   * @param string $file
   *
   * Constructor.
   */
  public function __construct(string $namespace, string $classname, ?string $file = null)
  {
    $this->namespace = $namespace;
    $this->classname = $classname;
    if (is_string($file)) {
      $this->file = $file;
      $this->fileExt = end(explode(".", $file));
    }
    $this->hash = str_replace("\\", "_", $namespace)."_".
      str_replace("\\", "_", $classname);
  }

  /**
   * @param string $filename
   * @return void
   */
  public static function startHeader(string $filename): void
  {
    $hash = md5($filename);
    echo "#ifndef __HEADER_{$hash}\n";
    echo "#define __HEADER_{$hash}\n\n";
    echo "#include \"greentea_php.h\"\n";
    echo "#include \"routes/WebRoutes.hpp\"\n";
  }

  /**
   * @param string $filename
   * @return void
   */
  public static function endHeader(string $filename): void
  {
    $hash = md5($filename);
    echo "#endif\n";
  }
}
