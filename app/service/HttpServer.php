<?php
namespace service;

class HttpServer
{
    public $swoole;

    public function start()
    {
        $this->swoole = new \Swoole\Http\Server('localhost', 9501);
//        $this->swoole->on('request', function ($request, $response) {
//            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
//        });
        $this->swoole->start();
    }




    public function onrequest()
    {
        $this->swoole->on('request', function ($request, $response) {
            $response->end("<h1>Hello Swoole. #".rand(1000, 9999)."</h1>");
        });
    }

}