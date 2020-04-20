<?php

function generate_class($file)
{
    ob_start();
    require $file;
    $out = ob_get_clean();

    return $out;
}

function begin_class(string $className)
{
return <<<BEGIN_CLASS
#define classname "{$className}"

BEGIN_CLASS;
}

function end_class()
{
return <<<END_CLASS

#undef classname
// end of class

END_CLASS;
}