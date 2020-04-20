
#include <stdio.h>
#include "greentea_php.h"

<?php echo begin_class("App/Controllers/IndexController"); ?>

PHP_METHOD(classname, __construct)
{
  printf("Initializing data...\n");
}

PHP_METHOD(classname, hello)
{
  return RETURN_STRING("Hello World")
}

<?php echo end_class(); ?>
