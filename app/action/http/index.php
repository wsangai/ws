<?php
namespace app\action\http;


class index
{
    public function index($request,$response)
    {
        $i= 1;
        $i++;
        $arr[] = $i;
        print_r($arr);
//        print_r(json_encode(compact('request','response')));
    }
}