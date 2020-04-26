
#define GREENTEA_MAIN
#include "greentea_php.h"

#include <routes/web.hpp>

#ifdef COMPILE_DL_GREENTEA
  #ifdef ZTS
    ZEND_TSRMLS_CACHE_DEFINE()
  #endif
#endif

ZEND_DECLARE_MODULE_GLOBALS(greentea);

extern zend_class_entry *GTPHP_HASH_GreenTea_GreenTea_ce;
extern const zend_function_entry GTPHP_HASH_GreenTea_GreenTea_methods[];

/**
 * Init.
 */
static PHP_MINIT_FUNCTION(greentea)
{
  zend_class_entry ce;

  INIT_NS_CLASS_ENTRY(ce, "GreenTea", "GreenTea", GTPHP_HASH_GreenTea_GreenTea_methods);
  GTPHP_HASH_GreenTea_GreenTea_ce = zend_register_internal_class(&ce TSRMLS_CC);





  greentea_init_routes();
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
