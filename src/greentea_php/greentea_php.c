
#define GREENTEA_MAIN
#include "greentea_php.h"

#ifdef COMPILE_DL_TEABOT7
    #ifdef ZTS
        ZEND_TSRMLS_CACHE_DEFINE()
    #endif
#endif

ZEND_DECLARE_MODULE_GLOBALS(greentea);

/**
 * Init.
 */
static PHP_MINIT_FUNCTION(greentea)
{
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
    TEABOT_VERSION,
    PHP_MODULE_GLOBALS(greentea),
    PHP_GINIT(greentea),
    NULL, /* GSHUTDOWN */
    NULL, /* RPOSTSHUTDOWN */
    STANDARD_MODULE_PROPERTIES_EX
};

ZEND_GET_MODULE(greentea);
