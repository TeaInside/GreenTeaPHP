<?php

$st = new GreenTea\GreenTea();
$a = $st->initWeb();

$st = new App\Http\Controllers\IndexController;
echo $st->hello();
echo "\n";

var_dump($_GET["data"]);
$_GET["qweasd"] = "zxc";
var_dump($_GET);