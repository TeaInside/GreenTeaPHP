
#include <stdio.h>

<?php echo ($st = new PHPClass("App\\Http\\Controllers", "IndexController")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("hello"); ?>
{
}

<?php $st->end(); PHPClass::expose($st); ?>
