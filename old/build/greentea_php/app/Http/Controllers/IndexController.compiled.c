
#include <stdio.h>

#include "greentea_php.h"

zend_class_entry *App_Controllers_IndexController_ce;

PHP_METHOD(App_Controllers_IndexController, __construct){
  printf("Initializing data...\n");
}

PHP_METHOD(App_Controllers_IndexController, hello){
  RETURN_STRING("Hello World")
}

const zend_function_entry App_Controllers_IndexController_methods[] = {
  PHP_ME(App_Controllers_IndexController, __construct, NULL, ZEND_ACC_CTOR|ZEND_ACC_PUBLIC)
  PHP_ME(App_Controllers_IndexController, hello, NULL, ZEND_ACC_PUBLIC)
  PHP_FE_END
};
