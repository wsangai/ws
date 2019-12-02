<?php
namespace service;

class HttpServer
{
    public $swoole;

    public function start()
    {
        $this->swoole = new \Swoole\Http\Server('localhost', 9501);

        $this->addEent();

        $this->swoole->start();
    }

    public function addEent()
    {
        $this->swoole->on('request', function ($request, $response) {
            (new \app\action\http\index())->index($request,$response);
        });

    }
}