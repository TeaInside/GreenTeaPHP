<?php

/**
 * @param string $class
 * @return void
 */
function greenTeaBuildAutoloader(string $class): void
{
    if (file_exists($f = __DIR__."/classes/".str_replace("\\", "/", $class).".php")) {
        require $f;
    }
}

spl_autoload_register("greenTeaBuildAutoloader");

class_alias(\GreenTeaPHP\Build\PHPClass::class, "PHPClass");
class_alias(\GreenTeaPHP\Build\CPPClass::class, "CPPClass");
class_alias(\GreenTeaPHP\Build\ConfigM4::class, "ConfigM4");
