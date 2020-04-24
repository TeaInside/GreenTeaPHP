
#include <stdio.h>
#include <string.h>
#include "greentea_php.h"

zval *get_server_var(char *key)
{
  return zend_hash_str_find(
    Z_ARRVAL(PG(http_globals)[TRACK_VARS_SERVER]),
    key, strlen(key));
}
