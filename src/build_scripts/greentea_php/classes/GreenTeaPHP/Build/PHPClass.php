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
  public function addMethod(string $name, array $attr = []): void
  {
    $this->methods[] = [
      "name" => $name,
      "attr" => $attr
    ];
    echo "PHP_METHOD({$this->hash}, {$method})";
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
      $v["attr"] = implode(" | ", $v["attr"]);
      $r .= "  PHP_ME({$this->hashed}, {$v["name"]}, NULL, {$v["attr"]})\n";
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
}
