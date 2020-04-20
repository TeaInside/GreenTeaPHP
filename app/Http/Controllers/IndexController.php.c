
#include <stdio.h>
#include "greentea_php.h"

<?php echo ($st = new PHPClass("App\\Controllers", "IndexController")); ?>

<?php $st->method("__construct"); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("hello"); ?>
{
  RETURN_STRING("Hello World")
}

<?php $st->end(); ?>
