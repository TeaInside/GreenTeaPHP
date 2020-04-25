
#include <stdio.h>

<?php echo ($st = new PHPClass("App\\Http\\Controllers", "IndexController")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("hello"); ?>
{
  zval
    *user_agent = get_server_var("HTTP_USER_AGENT"),
    *user_data  = get_get_var("data");



  if (user_data == NULL) {
    RETURN_STRING("no data")
  } else {
    RETURN_ZVAL(user_data, 0, 0);
  }
}

<?php $st->end(); PHPClass::expose($st); ?>
