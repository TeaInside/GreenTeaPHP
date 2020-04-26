
#include <cstdio>
#include <cstring>
#include <cstdlib>
#include <unistd.h>

#include <iostream>

using namespace std;

extern "C" {

<?php

echo ($st = new PHPClass("GreenTea", "Routes"));
$ce = function () use ($st) { echo $st->getHashed("_ce"); };

$st->addProperty("custom_url", "null", ["ZEND_ACC_PRIVATE"]);

?>


<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  char *uri;
  size_t uri_len;

  ZEND_PARSE_PARAMETERS_START(0, 1)
    Z_PARAM_OPTIONAL
    Z_PARAM_STRING(uri, uri_len)
  ZEND_PARSE_PARAMETERS_END();

  zend_update_property_stringl(
    <?php $ce(); ?>, getThis(), ZEND_STRL("custom_url"),
    uri, uri_len TSRMLS_DC);
}


<?php $st->method("initWeb"); ?>
{
  char *uri;
  size_t len;
  zval *z_uri;

  cout << "Initializing web...\n" << endl;

  char rtmp[] = "REQUEST_URI";
  z_uri = get_server_var(rtmp);

  if (z_uri == NULL) {
    char _slash[] = "/";
    uri = _slash;
    len = 1;
  } else {
    uri = z_uri->value.str->val;
    len = z_uri->value.str->len;
  }

  // router here...
}

<?php $st->end(); PHPClass::expose($st); ?>

}; // extern "C"
