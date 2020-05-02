
#include <iostream>

#include "Index.hpp"
#include <greentea/helpers/php.h>

namespace App::GreenTea::Controllers {

Index::Index(route_pass &_r): r(_r)
{
}

/**
 * Hello World!
 */
bool Index::hello()
{
  php_printf("Hello World!\n");
  return true;
}

/**
 * Get query string from URL.
 *
 * http://127.0.0.1?test=value
 */
bool Index::query_string()
{
  zval *test;
  test = get_get_var((char *)"test"); /* $_GET["test"] */

  /* Also works for $_POST, $_SERVER and $_FILES */
  /* get_post_var((char *)"test"); // $_POST["test"] */
  /* get_files_var((char *)"test"); // $_FILES["test"] */
  /* get_server_var((char *)"HTTP_USER_AGENT"); // $_SERVER["test"] */

  if (test != NULL) {
    php_printf("test parameter: \"%s\"", Z_STRVAL_P(test));
  } else {
    php_printf("test parameter doesn't exist");
  }
  return true;
}

/**
 * Call PHP function.
 */
bool Index::call_php_func()
{
  php_cf *cf;
  zval params[3] = {};
  uint32_t params_count = 3;

  /* integer */
  ZVAL_LONG(&params[0], 100); 

  /* float */
  ZVAL_DOUBLE(&params[1], 4.10);

  /* string */
  ZVAL_STRING(&params[2], "Hello World!");

  /* Init */
  cf = php_cf_ctor((char *)"var_dump", params_count);
  cf->params = params;

  /* Call var_dump($param0, $param1, $param2); */
  php_call_func(cf);

  /* Clean up. */
  php_cf_dtor(cf);
  zval_dtor(&params[0]);
  zval_dtor(&params[1]);
  zval_dtor(&params[2]);
  return true;
}


bool Index::php_global_var()
{
  zval *myvar;

  myvar = get_global_var_safe((char *)"myvar");
  if (myvar != NULL) {
    php_cf *cf;

    /* Init */
    cf = php_cf_ctor((char *)"var_dump", 1);
    cf->params = myvar;

    /* Call var_dump($param0, $param1, $param2); */
    php_call_func(cf);

    /* Clean up. */
    php_cf_dtor(cf);
  } else {
    php_printf("Global variable $myvar is undefined\n");
  }
  return true;
}

} // namespace App::GreenTea::Controllers

