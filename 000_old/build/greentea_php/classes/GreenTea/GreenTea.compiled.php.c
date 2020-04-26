
#include <stdio.h>
#include <string.h>
#include <unistd.h>

#include <routes/web.hpp>

#include "greentea_php.h"

zend_class_entry *GTPHP_HASH_GreenTea_GreenTea_ce;

PHP_METHOD(GTPHP_HASH_GreenTea_GreenTea, __construct){
  zend_is_auto_global_str((char*) ZEND_STRL("_SERVER"));
  zend_is_auto_global_str((char*) ZEND_STRL("_POST"));
  zend_is_auto_global_str((char*) ZEND_STRL("_GET"));
}

PHP_METHOD(GTPHP_HASH_GreenTea_GreenTea, initWeb){
  
}


PHP_METHOD(GTPHP_HASH_GreenTea_GreenTea, serveRequest){
  char *uri;
  size_t len;
  zval *z_uri;

  char rtmp[] = "REQUEST_URI";
  z_uri = get_server_var(rtmp);

  if (z_uri == NULL) {
    char _slash[] = "/";
    uri = _slash;
    len = 1;
  } else {
    uri = z_uri->value.str->val;
    len = z_uri->value.str->len;
  }
}

const zend_function_entry GTPHP_HASH_GreenTea_GreenTea_methods[] = {
  PHP_ME(GTPHP_HASH_GreenTea_GreenTea, __construct, NULL, ZEND_ACC_CTOR | ZEND_ACC_PUBLIC)
  PHP_ME(GTPHP_HASH_GreenTea_GreenTea, initWeb, NULL, ZEND_ACC_PUBLIC)
  PHP_ME(GTPHP_HASH_GreenTea_GreenTea, serveRequest, NULL, ZEND_ACC_PUBLIC)
  PHP_FE_END
};
