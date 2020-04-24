
#define GREENTEA_MAIN
#include "greentea_php.h"

#ifdef COMPILE_DL_GREENTEA
  #ifdef ZTS
    ZEND_TSRMLS_CACHE_DEFINE()
  #endif
#endif

ZEND_DECLARE_MODULE_GLOBALS(greentea);

extern zend_class_entry *greentea_greentea;
extern const zend_function_entry greentea_greentea_methods[];
<?php echo PhpClass::declareClasses(); ?>

/**
 * Init.
 */
static PHP_MINIT_FUNCTION(greentea)
{
  zend_class_entry ce_0;

  INIT_NS_CLASS_ENTRY(ce_0, "GreenTea", "GreenTea", greentea_greentea_methods);
  greentea_greentea = zend_register_internal_class(&ce_0 TSRMLS_CC);
  <?PHP echo PhpClass::minitClasses(); ?>

  REGISTER_INI_ENTRIES();
  return SUCCESS;
}

/**
 * Shutdown.
 */
static PHP_MSHUTDOWN_FUNCTION(greentea)
{
  UNREGISTER_INI_ENTRIES();
  return SUCCESS;
}

/**
 * Global init.
 */
static PHP_GINIT_FUNCTION(greentea)
{
  #if defined(COMPILE_DL_ASTKIT) && defined(ZTS)
    ZEND_TSRMLS_CACHE_UPDATE();
  #endif
}

zend_module_entry greentea_module_entry = {
  STANDARD_MODULE_HEADER,
  "greentea",
  NULL, /* functions */
  PHP_MINIT(greentea),
  PHP_MSHUTDOWN(greentea),
  NULL, /* RINIT */
  NULL, /* RSHUTDOWN */
  NULL, /* MINFO */
  GREENTEA_VERSION,
  PHP_MODULE_GLOBALS(greentea),
  PHP_GINIT(greentea),
  NULL, /* GSHUTDOWN */
  NULL, /* RPOSTSHUTDOWN */
  STANDARD_MODULE_PROPERTIES_EX
};

ZEND_GET_MODULE(greentea);
