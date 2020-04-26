<?php

namespace GreenTeaPHP\Build;

final class PHPClass
{
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
   * @var string
   */
  private $ext;

  /**
   * @param string
   */
  private $classDeclaration;

  /**
   * @param string $namespace
   * @param string $classname
   */
  public function __construct(string $namespace, string $classname)
  {
    $this->namespace = $namespace;
    $this->classname = $classname;
    $this->hashed = 
      "GTCPP_HASH_".
      str_replace("\\", "_", $namespace)."_".
      str_replace("\\", "_", $classname);
  }
}
