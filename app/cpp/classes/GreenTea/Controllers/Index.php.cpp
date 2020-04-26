
#include <iostream>

#include "Index.hpp"

namespace App::GreenTea::Controllers {

Index::Index(route_pass &_r): r(_r)
{
}

bool Index::hello()
{
  php_printf("Hello World from App::GreenTea::Controllers::Index::hello()\n");
  return true;
}

bool Index::queryString()
{
  HashTable *ht = Z_ARRVAL(PG(http_globals)[TRACK_VARS_GET]);

  ZEND_HASH_FOREACH(ht, 0)
    if (_p->key != NULL) {
      php_printf("qstr: \"%s\" = \"%s\"<br>", _p->key->val, Z_STRVAL_P(_z));
    }
  ZEND_HASH_FOREACH_END();

  return true;
}

bool Index::testCallSubstr()
{
  char *error = NULL;
  zend_fcall_info fci;
  zend_fcall_info_cache fci_cache;
  zval params[2], retval, callable;

  ZVAL_STRING(&callable, "substr");
  ZVAL_STRING(&(params[0]), "abcdef");
  ZVAL_LONG(&(params[1]), 3);

  zend_fcall_info_init(&callable, 0, &fci, &fci_cache, NULL, &error);
  fci.params = params;
  fci.param_count = 2;
  fci.retval = &retval;


  if (zend_call_function(&fci, &fci_cache) == SUCCESS && Z_TYPE(retval) != IS_UNDEF) {
    if (Z_ISREF(retval)) {
      zend_unwrap_reference(&retval);
    }
  }
  // output must be "def"
  php_printf("Output: %s\n", Z_STRVAL(retval));
  zval_dtor(&params[0]);
  zval_dtor(&params[1]);
  zval_dtor(&callable);
  zval_dtor(&retval);
  return true;
}

} // namespace App::GreenTea::Controllers
