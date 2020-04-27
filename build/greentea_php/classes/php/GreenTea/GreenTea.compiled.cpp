
#include "greentea_php.h"

zend_class_entry *GTPHP_HASH_GreenTea_GreenTea_ce;

#include "routes/WebRoutes.hpp"

PHP_METHOD(GTPHP_HASH_GreenTea_GreenTea, __construct)
{
  zend_is_auto_global_str((char*) ZEND_STRL("_SERVER"));
  zend_is_auto_global_str((char*) ZEND_STRL("_POST"));
  zend_is_auto_global_str((char*) ZEND_STRL("_GET"));
}

inline static void split_query_str(
  char *uri, size_t *uri_len, char **query_str, size_t *query_str_len)
{
  register size_t i;
  register size_t len = *uri_len;
  for (i = 0; i < len; i++) {
    if (uri[i] == '?') {
      *query_str_len = (*uri_len) - i - 1;
      *uri_len = i;
      *query_str = &(uri[i + 1]);
      uri[i] = '\0';
      break;
    }
  }
}

PHP_METHOD(GTPHP_HASH_GreenTea_GreenTea, initWeb)
{
  zval *z_uri;
  size_t uri_len = 1, query_str_len = 0;
  char *uri,
    *query_str = NULL,
    slash[] = "/",
    req_uri[] = "REQUEST_URI";

  z_uri = get_server_var(req_uri);

  if (z_uri == NULL) {
    uri = slash;
  } else {
    uri = z_uri->value.str->val;
    uri_len = z_uri->value.str->len;
  }

  split_query_str(uri, &uri_len, &query_str, &query_str_len);
  RouteExec(uri, uri_len, query_str, query_str_len);
}

extern "C" const zend_function_entry GTPHP_HASH_GreenTea_GreenTea_methods[] = {
  PHP_ME(GTPHP_HASH_GreenTea_GreenTea, __construct, NULL, ZEND_ACC_CTOR | ZEND_ACC_PUBLIC)
  PHP_ME(GTPHP_HASH_GreenTea_GreenTea, initWeb, NULL, ZEND_ACC_PUBLIC)
  PHP_FE_END
};
