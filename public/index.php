<?php

$st = new GreenTea\GreenTea();
$a = $st->initWeb();

$st = new App\Http\Controllers\IndexController;
echo $st->hello();
