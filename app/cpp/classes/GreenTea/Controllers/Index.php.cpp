
#include <iostream>

<?php
$st = new PHPClass("GreenTea\\Controllers", "Index", __FILE__);
$st->start();
?>


<?php
$st->end();
PHPClass::expose($st);
?>