
#include <stdio.h>
#include <string.h>
#include "greentea_php.h"

zval *get_server_var(char *key)
{
  return zend_hash_str_find(
    Z_ARRVAL(PG(http_globals)[TRACK_VARS_SERVER]),
    key, strlen(key));
}

zval *get_post_var(char *key)
{
  return zend_hash_str_find(
    Z_ARRVAL(PG(http_globals)[TRACK_VARS_POST]),
    key, strlen(key));
}

zval *get_get_var(char *key)
{
  return zend_hash_str_find(
    Z_ARRVAL(PG(http_globals)[TRACK_VARS_GET]),
    key, strlen(key));
}