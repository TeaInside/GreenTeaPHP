<?php

namespace GreenTeaPHP\Build;

final class PHPClass
{
  /**
   * @var array
   */
  private static $phpClasses = [];

  /**
   * @var array
   */
  private static $compiledFiles = [];

  /**
   * @var array
   */
  private static $initScripts = [];

  /**
   * @var string
   */
  private $hashed;

  /**
   * @var string
   */
  private $namespace;

  /**
   * @var string
   */
  private $classname;

  /**
   * @var array
   */
  private $methods = [];

  /**
   * @param string $namespace
   * @param string $classname
   */
  public function __construct(string $namespace, string $classname)
  {
    $this->namespace = $namespace;
    $this->classname = $classname;
    $this->hashed = 
      "GTPHP_HASH_".
      str_replace("\\", "_", $namespace)."_".
      str_replace("\\", "_", $classname);
  }

  /**
   * @return string
   */
  public function __toString()
  {
    $r = "#include \"greentea_php.h\"\n\n";
    $r .= "zend_class_entry *{$this->hashed}_ce;\n";
    return $r;
  }

  /**
   * @param bool $ret
   * @return ?string
   */
  public function end(bool $ret = false): ?string
  {
    $r = "const zend_function_entry {$this->hashed}_methods[] = {\n";
    foreach ($this->methods as $k => $v) {
      $v["attr"] = implode("|", $v["attr"]);
      $r .= "  PHP_ME({$this->hashed}, {$v["name"]}, NULL, {$v["attr"]})\n";
    }
    $r .= "  PHP_FE_END\n";
    $r .= "};\n";

    if ($ret) {
      return $ret;
    } else {
      echo $r;
      return null;
    }
  }

  /**
   * @param string $method
   * @param array  $attr
   * @param bool   $ret
   * @return ?string
   */
  public function method(string $method, array $attr = [], bool $ret = false): ?string
  {
    // Make sure a method has access modifer.
    // Set to public if it is not provided.
    if (
      (array_search("ZEND_ACC_PUBLIC", $attr) === false) &&
      (array_search("ZEND_ACC_PRIVATE", $attr) === false) &&
      (array_search("ZEND_ACC_PROTECTED", $attr) === false)) {
      $attr[] = "ZEND_ACC_PUBLIC";
    }

    $this->methods[] = [
      "name" => $method,
      "attr" => $attr
    ];
    $r = "PHP_METHOD({$this->hashed}, {$method})";
    if ($ret) {
      return $ret;
    } else {
      echo $r;
      return null;
    }
  }

  /**
   * @return string
   */
  public function getClassname(): string
  {
    return $this->classname;
  }

  /**
   * @return string
   */
  public function getNamespace(): string
  {
    return $this->namespace;
  }

  /**
   * @return string
   */
  public function getHashed(): string
  {
    return $this->hashed;
  }

  /**
   * @param PHPClass
   * @return void
   */
  public static function expose(PHPClass $phpClass): void
  {
    self::$phpClasses[] = $phpClass;
  }

  /**
   * @return string
   */
  public static function declareClasses(): string
  {
    $str = "";
    foreach (self::$phpClasses as $k => $v) {
      $hashed = $v->getHashed();
      $str .= "extern zend_class_entry *{$hashed}_ce;\n";
      $str .= "extern const zend_function_entry {$hashed}_methods[];\n";
    }
    return $str;
  }

  /**
   * @return string
   */
  public static function minitClasses(): string
  {
    $str = "zend_class_entry ce;\n\n";
    foreach (self::$phpClasses as $k => $v) {
      $hashed = $v->getHashed();
      $namespace = str_replace("\\", "\\\\", $v->getNamespace());
      $classname = str_replace("\\", "\\\\", $v->getClassname());
      $str .= "  INIT_NS_CLASS_ENTRY(ce, \"{$namespace}\", \"{$classname}\", {$hashed}_methods);\n";
      $str .= "  {$hashed}_ce = zend_register_internal_class(&ce TSRMLS_CC);\n";
    }
    $str .= "\n\n";
    foreach (self::$initScripts as $k => $v) {
      $str .= $v;
    }
    $str .= "\n\n";
    return $str;
  }

  /**
   * @param string $source
   * @param string $targetDir
   * @param string $targetFile
   * @param bool   $postScript
   * @return void
   */
  public static function compile(string $source, string $targetDir, string $targetFile, bool $postScript = false): void
  {
    ob_start();
    require $source;
    $out = ob_get_clean();
    $name = basename($source);
    $hash = md5($out);
    $hashNow = file_exists($targetDir."/".$targetFile) 
      ? md5(file_get_contents($targetDir."/".$targetFile)) : null;
    if ($hash !== $hashNow) {
      file_put_contents($targetDir."/".$targetFile, $out);
    }
    $postScript and self::$compiledFiles[] = [
      "file" => $targetFile,
      "dir" => $targetDir
    ];
  }

  /**
   * @return &array
   */
  public static function &getCompiledFiles(): array
  {
    return self::$compiledFiles;
  }

  /**
   * @param string $initScript
   * @return void
   */
  public function addInit(string $initScript)
  {
    self::$initScripts[] = $initScript;
  }

  /**
   * @param string $name
   * @return void
   */
  public function addProperty(string $name, string $type)
  {
    switch ($type) {
      case "null":
        $r = "zend_declare_property_null({$this->hashed}_ce, ZEND_STRL(\"{$name}\"), ZEND_ACC_PRIVATE TSRMLS_CC);\n";
      break;
      
      default:
        
      break;
    }
    echo "/** addProperty({$name}, {$type}); **/\n";
    self::$initScripts[$this->hashed] .= "  ".$r;
  }
}
