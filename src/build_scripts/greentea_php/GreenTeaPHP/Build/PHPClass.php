<?php

namespace GreenTeaPHP\Build;

final class PHPClass
{
    /**
     * @var array
     */
    private static $phpClasses = [];

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
     * @param string $namespace
     * @param string $classname
     */
    public function __construct(string $namespace, string $classname)
    {
        $this->namespace = $namespace;
        $this->classname = $classname;
        $this->hashed = 
            str_replace("\\", "_", $namespace)."_".
            str_replace("\\", "_", $classname)."__hash";
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
            $str .= "extern zend_class_entry *{$hashed};\n";
            $str .= "extern const zend_function_entry {$hashed}_methods[];\n";
        }
        return $str;
    }

    /**
     * @return string
     */
    public static function minitClasses(): string
    {
        $str = "";
        foreach (self::$phpClasses as $k => $v) {
            $hashed = $v->getHashed();
            $namespace = $v->getNamespace();
            $classname = $v->getClassname();
            $str .= "INIT_NS_CLASS_ENTRY(ce_0, \"{$namespace}\", \"{$classname}\", greentea_greentea_methods);\n";
            $str .= "{$hashed} = zend_register_internal_class(&ce_0 TSRMLS_CC);";
        }
    }
}
