
#include <stdio.h>
#include <string.h>
#include <stdbool.h>

#include "greentea_php.h"

#ifdef __cplusplus
extern "C" {
#endif

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

#ifdef __cplusplus
}
#endif
