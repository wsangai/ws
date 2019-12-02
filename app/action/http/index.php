<?php
namespace app\action\http;


class index
{
    public function index($request,$response)
    {
        echo 1;
        $arr = \service\artisan\config::get('app');
        print_r($arr);
//        print_r(json_encode(compact('request','response')));
    }
}