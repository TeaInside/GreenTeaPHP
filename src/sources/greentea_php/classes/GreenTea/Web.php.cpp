
<?php
$st = new PHPClass("GreenTea", "Web", __FILE__);
$st->start();
?>


<?php $st->method("__construct", ["ZEND_ACC_CTOR"]); ?>
{
}


<?php $st->end(); PHPClass::expose($st); ?>
