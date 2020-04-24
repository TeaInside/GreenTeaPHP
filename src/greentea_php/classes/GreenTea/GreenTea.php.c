
<?php echo ($st = new PHPClass("GreenTea", "GreenTea")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
  printf("Initializing data...\n");
}

<?php $st->method("initWeb"); ?>
{
  
}

<?php $st->end(); PHPClass::expose($st); ?>
