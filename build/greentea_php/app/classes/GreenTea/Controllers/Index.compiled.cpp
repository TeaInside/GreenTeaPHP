
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
  int i = 0;
  HashTable *ht = Z_ARRVAL(PG(http_globals)[TRACK_VARS_GET]);

  ZEND_HASH_FOREACH(ht, 0)
    if (_p->key != NULL) {
      php_printf(
        "Query string [%d]: \"%s\" = \"%s\"<br>",
        i,
        _p->key->val,
        Z_STRVAL_P(_z)
      );
      i++;
    }
  ZEND_HASH_FOREACH_END();

  return true;
}

bool Index::dumpQueryString()
{
  php_cf *cf = php_cf_ctor((char *)"var_dump", 1);
  cf->params = &(PG(http_globals)[TRACK_VARS_GET]);
  php_call_func(cf);
  php_cf_dtor(cf);
  return true;
}

} // namespace App::GreenTea::Controllers
