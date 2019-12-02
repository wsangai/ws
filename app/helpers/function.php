<?php

function config()
{

}

/**
 * 转array
 * @param
 * @return array
 */
function data2array($result)
{
    //判断 obj/json/xml
    if (is_array($result)) {
        return $result;
    }


    if (xml_parse(xml_parser_create(), $result, true)) {
        $res = \service\artisan\format::xml2array($result);
        if (isset($res['string'])) {
            return @json_decode($res['string'], true);
        }
        return $res;
    }

    if (is_object($result)) {
        return json_decode(json_encode($result), true);
    }

    $res = @json_decode($result, true);
    if (json_last_error() == JSON_ERROR_NONE) {
        return $res;
    }

    return [];
}

/**
 ***********************************************************************************************************************
 * 系统日志函数
 ***********************************************************************************************************************
 */

use  \service\artisan\logger\logger;

/**
 * db : 特定格式的log
 * @param string $handleDriver
 * @return \service\artisan\logger\storage\file|\service\artisan\logger\storage\db
 */
function getLogHandler($handleDriver = 'file')
{
    return \service\artisan\logger\LogUtil::getHandler($handleDriver);
}

/**
 * @param $message
 * @param string $breakpoint
 * @param string $service_name
 * @return bool
 */
function logInfo($message, $breakpoint = '', $service_name = '',$isRecordAll=false)
{
    return logger::add(logger::INFO, $message, [], $breakpoint, $service_name,$isRecordAll);
}

/**
 * @param $message
 * @param string $breakpoint
 * @param string $service_name
 * @return bool
 */
function logError($message, $breakpoint = '', $service_name = '',$isRecordAll=false)
{
    return logger::add(logger::ERROR, $message, [], $breakpoint, $service_name,$isRecordAll);
}

/**
 * @param $message
 * @param string $breakpoint
 * @param string $service_name
 * @return bool
 */
function logNotice($message, $breakpoint = '', $service_name = '',$isRecordAll=false)
{
    return logger::add(logger::NOTICE, $message, [], $breakpoint, $service_name,$isRecordAll);
}


/**
 * @param $message
 * @param string $breakpoint
 * @param string $service_name
 * @return bool
 */
function logCritical($message, $breakpoint = '', $service_name = '',$isRecordAll=false)
{
    return logger::add(logger::CRITICAL, $message, [], $breakpoint, $service_name,$isRecordAll);
}

/**
 * @param string $value
 * @param null $result
 * @return bool
 */
function is_serialized($value, &$result = null) {
    if (\is_string($value)) {
        //not int less than 5 only possible is bool and null
        if (($length = \strlen($value)) === 4) {
            $map = [
                'b:1;' => true,
                'b:0;' => false,
                'i:0;' => 0,
                'i:1;' => 1,
                'i:2;' => 2,
                'i:3;' => 3,
                'i:4;' => 4,
                'i:5;' => 5,
                'i:6;' => 6,
                'i:7;' => 7,
                'i:8;' => 8,
                'i:9;' => 9,
            ];
            if (isset($map[$value])) { //7.1下性能更好
                $result = $map[$value];
                return true;
            }
        } elseif($length > 4) {
            //compare first three and last char || may be last two char
            //split these conditions out may be faster
            if (\ctype_digit($value[2]) && \strpos('|i:;|d:;|s:;|a:}|O:}|C:}|', '|' . $value[0] . $value[1] . $value[$length - 1] . '|') !== false && ($result = @\unserialize($value)) !== false) {
                return true;
            }
        } elseif ($length === 2) {
            if ('N;' === $value) {
                return true;
            }
        }
    }
    return false;
}

