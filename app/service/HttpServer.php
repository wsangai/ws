<?php
namespace service;

class HttpServer
{
    public static function start()
    {
        $swoole = new \Swoole\Http\Server('127.0.0.1', 9501);

        $swoole->start();
    }
}