<?php

require_once  './vendor/autoload.php';

(new \service\HttpServer())->start();
(new \service\HttpServer())->onrequest();
