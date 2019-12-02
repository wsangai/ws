<?php

define('APPPATH', __DIR__ . '/app/');

require_once  './vendor/autoload.php';

(new \service\HttpServer())->start();
