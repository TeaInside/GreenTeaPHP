
#include <stdio.h>

<?php echo ($st = new PHPClass("App\\Http\\Controllers", "IndexController")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("hello"); ?>
{
  zval *user_agent = get_server_var("HTTP_USER_AGENT");

  RETURN_STRING(user_agent->value.str->val);
}

<?php $st->end(); PHPClass::expose($st); ?>
