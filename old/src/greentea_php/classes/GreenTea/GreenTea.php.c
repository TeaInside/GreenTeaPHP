
#include <stdio.h>
#include <string.h>
#include <unistd.h>

#include <routes/web.hpp>

<?php echo ($st = new PHPClass("GreenTea", "GreenTea")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  zend_is_auto_global_str((char*) ZEND_STRL("_SERVER"));
  zend_is_auto_global_str((char*) ZEND_STRL("_POST"));
  zend_is_auto_global_str((char*) ZEND_STRL("_GET"));
}

<?php $st->method("initWeb"); ?>
{
  
}


<?php $st->method("serveRequest"); ?>
{
  char *uri;
  size_t len;
  zval *z_uri;

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
}

<?php $st->end(); PHPClass::expose($st); ?>
