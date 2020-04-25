<?php

$greenTea = new GreenTea\GreenTea();
$greenTea->initWeb();

$routes = new GreenTea\Routes($_SERVER["REQUEST_URI"] ?? "/");
$routes->initWeb();

$st = new App\Http\Controllers\IndexController();
$a = $st->hello();
