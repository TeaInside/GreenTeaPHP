
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <unistd.h>

<?php
echo ($st = new PHPClass("GreenTea", "Routes"));
$ce  = function () use ($st) { echo $st->getHashed()."_ce"; };

$st->addProperty("uri", "null");

?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  char *uri;
  size_t uri_len;

  ZEND_PARSE_PARAMETERS_START(1, 1)
    Z_PARAM_STRING(uri, uri_len)
  ZEND_PARSE_PARAMETERS_END();

  zend_update_property_stringl(
    <?php $ce(); ?>, getThis(), ZEND_STRL("uri"),
    uri, uri_len TSRMLS_DC);
}

<?php $st->method("initWeb"); ?>
{
  char *uri;
  size_t len;
  zval *z_uri;

  z_uri = get_server_var("REQUEST_URI");

  if (z_uri == NULL) {
    char _slash[] = "/";
    uri = _slash;
    len = 1;
  } else {
    uri = z_uri->value.str->val;
    len = z_uri->value.str->len;
  }

  printf("URI: %s\n", uri);
}


<?php
$st->end();
PHPClass::expose($st);
?>
