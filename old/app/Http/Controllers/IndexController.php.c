
#include <stdio.h>

<?php echo ($st = new PHPClass("App\\Controllers", "IndexController")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("hello"); ?>
{
  RETURN_STRING("Hello World")
}

<?php $st->end(); PHPClass::expose($st); ?>
