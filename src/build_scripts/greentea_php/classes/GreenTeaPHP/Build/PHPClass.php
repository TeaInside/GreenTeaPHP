<?php

namespace GreenTeaPHP\Build;

/**
 * @author Ammar Faizi <ammarfaizi2@gmail.com>
 * @license MIT
 * @package \GreenTeaPHP\Build
 * @version 0.0.1
 */
final class PHPClass
{
  /**
   * @var array
   */
  private static $exposedClasses = [];

  /**
   * @var array
   */
  private static $initScripts = [];

  /**
   * @var array
   */
  private static $pendingM4Files = [];

  /**
   * @var array
   */
  private static $appEntryFiles = [];

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
   * @var string
   */
  private $fileExt = "c";

  /**
   * @var array
   */
  private $properties = [];

  /**
   * @var array
   */
  private $methods = [];

  /**
   * @var string
   */
  private $hash;

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
    $this->hash = "GTPHP_HASH_".
      str_replace("\\", "_", $namespace)."_".
      str_replace("\\", "_", $classname);
  }

  /**
   * @param string $prefix
   * @param string $suffix
   * @return string
   */
  public function getHash(string $prefix = "", string $suffix = ""): string
  {
    return $prefix.$this->hash.$suffix;
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
  public function getClassname(): string
  {
    return $this->classname;
  }

  /**
   * @param string $name
   * @param string $type
   * @param array  $attr
   * @return void
   */
  public function addProperty(string $name, string $type, array $attr = []): void
  {
    $this->properties[] = [
      "name" => $name,
      "type" => $type,
      "attr" => $attr
    ];
    echo "/* addProperty({$name}, {$type}, ".json_encode($attr)."); */\n";
  }

  /**
   * @param string $name
   * @param array  $attr
   */
  public function method(string $name, array $attr = []): void
  {
    $this->methods[] = [
      "name" => $name,
      "attr" => $attr
    ];
    echo "PHP_METHOD({$this->hash}, {$name})\n";
  }

  /**
   * @return void
   */
  public function start(): void
  {
    $r = "#include \"greentea_php.h\"\n\n";
    $r .= "zend_class_entry *{$this->hash}_ce;\n";

    echo $r;
  }

  /**
   * @return void
   */
  public function end(): void
  {
    if ($this->fileExt === "c") {
      $r = "";
    } else {
      $r = "extern \"C\" ";
    }

    $r .= "const zend_function_entry {$this->hash}_methods[] = {\n";
    foreach ($this->methods as $k => $v) {

      if ((array_search("ZEND_ACC_PUBLIC", $v["attr"]) === false) &&
          (array_search("ZEND_ACC_PRIVATE", $v["attr"]) === false) &&
          (array_search("ZEND_ACC_PROTECTED", $v["attr"]) === false)) {
        $v["attr"][] = "ZEND_ACC_PUBLIC";
      }
      $v["attr"] = implode(" | ", $v["attr"]);

      $r .= "  PHP_ME({$this->hash}, {$v["name"]}, NULL, {$v["attr"]})\n";
    }
    $r .= "  PHP_FE_END\n};\n";

    echo $r;
  }

  /**
   * @param \GreenTeaPHP\Build\PHPClass $class
   * @return void
   */
  public static function expose(PHPClass $class): void
  {
    self::$exposedClasses[] = $class;
  }

  /**
   * @return void
   */
  public static function buildMinitClasses(): void
  {
    $r = "zend_class_entry ce;\n";
    foreach (self::$exposedClasses as $k => $v) {
      $hash = $v->getHash();
      $namespace = str_replace("\\", "\\\\", $v->getNamespace());
      $classname = str_replace("\\", "\\\\", $v->getClassname());
      $r .= "  INIT_NS_CLASS_ENTRY(ce, \"{$namespace}\", \"{$classname}\", {$hash}_methods);\n";
      $r .= "  {$hash}_ce = zend_register_internal_class(&ce TSRMLS_CC);\n";
    }

    $r .= "\n\n";
    foreach (self::$initScripts as $k => $v) {
      $r .= $v;
    }
    $r .= "\n\n";
    echo $r;
  }

  /**
   * @return void
   */
  public static function declareClasses(): void
  {
    $r = "";
    foreach (self::$exposedClasses as $k => $v) {
      $hash = $v->getHash();
      $r .= "extern zend_class_entry *{$hash}_ce;\n";
      $r .= "extern const zend_function_entry {$hash}_methods[];\n";
    }
    echo $r;
  }

  /**
   * @param string $sourceFile
   * @param string $targetFile
   * @return void
   */
  public static function compile(string $sourceFile, string $targetFile): void
  {
    ob_start();
    require $sourceFile;
    $out = ob_get_clean();
    $curHash = md5($out);
    $oldHash = file_exists($targetFile) ? md5_file($targetFile) : null;

    if ($curHash !== $oldHash) {
      file_put_contents($targetFile, $out);
    }
  }

  /**
   * @return void
   */
  public static function addAppFile(string $file): void
  {
    self::$appEntryFiles[] = $file;
  }

  /**
   * @return void
   */
  public static function buildAppEntry(): void
  {
    foreach (self::$appEntryFiles as $file) {
      echo "#include \"{$file}\"\n";
    }
  }
}
