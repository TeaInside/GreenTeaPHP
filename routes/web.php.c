
<?php echo ($st = new PHPClass("GreenTea", "Routes")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
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

<?php $st->end(); PHPClass::expose($st); ?>
