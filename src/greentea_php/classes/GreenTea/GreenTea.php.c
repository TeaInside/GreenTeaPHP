
<?php echo ($st = new PHPClass("GreenTea", "GreenTea")); ?>

extern HashTable *server;

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("initWeb"); ?>
{
  zend_is_auto_global_str((char*) ZEND_STRL("_SERVER"));
}

<?php $st->end(); PHPClass::expose($st); ?>
