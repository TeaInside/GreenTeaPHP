
#include <stdio.h>

<?php echo ($st = new PHPClass("App\\Http\\Controllers", "IndexController")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
}

<?php $st->method("hello"); ?>
{
  php_printf("Hello World!\n");
}

<?php $st->end(); PHPClass::expose($st); ?>
