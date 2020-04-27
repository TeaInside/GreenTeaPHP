
#ifndef HELPERS__PHP_H
#define HELPERS__PHP_H

#include <stdint.h>

typedef struct {
  zval *params;
  zval retval;
  zval callable;
  uint32_t param_count;
} php_cf;

zval *php_call_func(php_cf *in);
php_cf *php_cf_ctor(char *fname, uint32_t param_count);
void php_cf_dtor(php_cf *st);

#endif
