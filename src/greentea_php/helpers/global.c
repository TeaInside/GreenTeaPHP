
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

char *strtolower(char *str, unsigned int len)
{
  for (unsigned int i = 0; i < len; i++) {
    if ((str[i] >= 'A') && (str[i] <= 'Z')) {
      str[i] += 32;
    }
  }
  return str;
}

char *strtoupper(char *str, unsigned int len)
{
  for (unsigned int i = 0; i < len; i++) {
    if ((str[i] >= 'a') && (str[i] <= 'z')) {
      str[i] -= 32;
    }
  }
  return str;
}

/** 
 * Warning, returned address may not be the same as input.
 *
 * In case you are using malloc, you should save the address
 * returned by malloc to free it later.
 */
char *trim(char *str)
{
  bool trim = false;
  unsigned long long i = 0, len = strlen(str) - 1;
  while ((str[i] == ' ') || (str[i] == '\r') || (str[i] == '\t') || (str[i] == '\n')) {
    i++;
  }
  str = &(str[i]);

  while ((str[len] == ' ') || (str[len] == '\r') || (str[len] == '\t') || (str[len] == '\n')) {
    len--;
    trim = true;
  }

  if (trim) {
    str[len + 1] = '\0';
  }
  return str;
}
