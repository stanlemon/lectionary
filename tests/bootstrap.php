<?php
$rootDir = dirname(__DIR__);
$autoloader = require $rootDir . '/vendor/autoload.php';
$autoloader->add("Lutheran", $rootDir . '/tests');