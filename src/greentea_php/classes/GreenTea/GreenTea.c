
#include <stdio.h>
#include "../../greentea_php.h"

zend_class_entry *greentea_greentea;

/**
 * Constructor.
 */
PHP_METHOD(GreenTea_GreenTea, __construct)
{
}

/**
 * @return void
 */
PHP_METHOD(GreenTea_GreenTea, init)
{
  printf("Greentea initialized!\n");
}

const zend_function_entry greentea_greentea_methods[] = {
  PHP_ME(GreenTea_GreenTea, __construct, NULL, ZEND_ACC_PUBLIC | ZEND_ACC_CTOR)
  PHP_ME(GreenTea_GreenTea, init, NULL, ZEND_ACC_PUBLIC)
  PHP_FE_END
};
