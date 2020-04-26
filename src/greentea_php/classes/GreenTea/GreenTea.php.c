
#include <stdio.h>
#include <string.h>
#include <unistd.h>

<?php echo ($st = new PHPClass("GreenTea", "GreenTea")); ?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
}

<?php $st->method("initWeb"); ?>
{
  zend_is_auto_global_str((char*) ZEND_STRL("_SERVER"));
  zend_is_auto_global_str((char*) ZEND_STRL("_POST"));
  zend_is_auto_global_str((char*) ZEND_STRL("_GET"));
}

<?php $st->end(); PHPClass::expose($st); ?>
