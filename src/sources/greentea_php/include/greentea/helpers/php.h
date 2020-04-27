
#ifndef HELPERS__PHP_H
#define HELPERS__PHP_H

#include "greentea_php.h"
#include <stdint.h>

#ifdef __cplusplus
extern "C" {
#endif

typedef struct {
  zval *params;
  zval retval;
  zval callable;
  uint32_t param_count;
} php_cf;

zval *php_call_func(php_cf *in);
php_cf *php_cf_ctor(char *fname, uint32_t param_count);
void php_cf_dtor(php_cf *st);

#ifdef __cplusplus
}
#endif

#endif
