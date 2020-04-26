
#include <iostream>

<?php
$st = new PHPClass("GreenTea\\Controllers", "Index", __FILE__);
$st->start();
?>

<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{

}

<?php $st->method("hello"); ?>
{
  php_printf("Hello World from Index!\n");
}

<?php
$st->end();
PHPClass::expose($st);
?>
