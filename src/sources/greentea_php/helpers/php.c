
#include <greentea/helpers/php.h>

zval *php_call_func(php_cf *in)
{
  char *error = NULL;
  zend_fcall_info fci;
  zend_fcall_info_cache fci_cache;
  zval callable;

  zend_fcall_info_init(&callable, 0, &fci, &fci_cache, NULL, &error);

  if (error) {
    efree(error);
    php_printf("Error: %s\n");
    return NULL;
  }

  fci.params = in.params;
  fci.param_count = in.param_count;
  fci.retval = &(in.retval);

  if (zend_call_function(&fci, &fci_cache) == SUCCESS && Z_TYPE(retval) != IS_UNDEF) {
    if (Z_ISREF(in.retval)) {
      zend_unwrap_reference(&(in.retval));
    }
  }

  return &(in.retval);
}

php_cf *php_cf_ctor(char *fname, uint32_t param_count)
{
  php_cf *st = (php_cf *)emalloc(sizeof(php_cf));
  ZVAL_STRING(&(st->callable), fname);
  st->param_count = param_count;
  st->params = (zval *)emalloc(sizeof(zval) * (param_count + 1));
}

void php_cf_dtor(php_cf *st)
{
  if (st == NULL) {
    return;
  }
  efree(st->params);
  zval_dtor(&(st->callable));
  efree(st);
}
