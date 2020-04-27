
#include <iostream>

#include "Index.hpp"
#include <greentea/helpers/php.h>

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

bool Index::dumpQueryString()
{
  php_cf *cf = php_cf_ctor((char *)"var_dump", 1);
  ZVAL_NEW_STR(&(cf->params));
  Z_ARRVAL(cf->params[0]) = Z_ARRVAL(PG(http_globals)[TRACK_VARS_GET]);
  if (php_call_func(cf)) {

  }
  return true;
}

} // namespace App::GreenTea::Controllers
