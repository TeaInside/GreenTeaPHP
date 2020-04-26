
#include <stdio.h>

#include "greentea_php.h"

zend_class_entry *GTPHP_HASH_App_Http_Controllers_IndexController_ce;

PHP_METHOD(GTPHP_HASH_App_Http_Controllers_IndexController, __construct){
}

PHP_METHOD(GTPHP_HASH_App_Http_Controllers_IndexController, hello){
  php_printf("Hello World!\n");
}

const zend_function_entry GTPHP_HASH_App_Http_Controllers_IndexController_methods[] = {
  PHP_ME(GTPHP_HASH_App_Http_Controllers_IndexController, __construct, NULL, ZEND_ACC_CTOR | ZEND_ACC_PUBLIC)
  PHP_ME(GTPHP_HASH_App_Http_Controllers_IndexController, hello, NULL, ZEND_ACC_PUBLIC)
  PHP_FE_END
};
