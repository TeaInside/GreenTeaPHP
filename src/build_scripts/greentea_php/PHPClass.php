<?php

final class PHPClass
{
    /**
     * @var string
     */
    private $namespace;

    /**
     * @var string
     */
    private $className;

    /**
     * @var string
     */
    private $hashed;

    /**
     * @var array
     */
    private $methods = [];

    /**
     * @param string $namespace
     * @param string $className
     *
     * Constructor.
     */
    public function __construct(string $namespace, string $className)
    {
        $this->namespace = $namespace;
        $this->className = $className;
        $this->hashed =
            str_replace("\\", "_", $namespace)."_".
            str_replace("\\", "_", $className);
    }

    /**
     * @param string $method
     * @param array  $attr
     * @return void
     */
    public function method(string $method, array $attr = []): void
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
        echo $r;
    }

    /**
     * @param void
     */
    public function end(): void
    {
        $r = "const zend_function_entry {$this->hashed}_methods[] = {\n";
        foreach ($this->methods as $k => $v) {
            $r .= "  PHP_ME({$this->hashed}, {$v}, NULL, )\n";
        }
        $r .= "  PHP_FE_END\n";
        $r .= "};";

        echo $r;
    }
}
