
#ifndef GREENTEA_PHP_H
#define GREENTEA_PHP_H
  #define GREENTEA_PHP_H
  #define GREENTEA_VERSION "0.0.1"

  #include "php.h"

  #ifdef HAVE_CONFIG_H
    #include "config.h"
  #endif

  #ifdef ZTS
    #include "TSRM.h"
  #endif

  PHP_INI_BEGIN()
  PHP_INI_END()

  #ifndef GREENTEA_PHP_MAIN
    #include <greentea/helpers/global.h>
    extern zend_module_entry greentea_module_entry;
  #endif

  ZEND_BEGIN_MODULE_GLOBALS(greentea)
  ZEND_END_MODULE_GLOBALS(greentea)
  ZEND_EXTERN_MODULE_GLOBALS(greentea)
  #define GREENTEAG(v) ZEND_MODULE_GLOBALS_ACCESSOR(greentea, v)


  #if defined(ZTS) && defined(COMPILE_DL_SAMPLE)
    ZEND_TSRMLS_CACHE_EXTERN()
  #endif

  #define phpext_greentea_ptr (&greentea_module_entry)
#endif
