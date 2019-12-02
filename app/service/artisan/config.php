<?php
/**
 ***********************************************************************************************************************
 * 配置文件装载类
 * @author llq
 ***********************************************************************************************************************
 */

namespace service\artisan;

/**
 * Class config
 * @package artisan
 */
class config
{
    /**
     * 单例模式容器
     * @var array
     */
    private static $container = [];

    /**
     * 应用路径 优先级最高
     * @var string
     */
    private static $appPath = APPPATH;


    /**
     * @param string $file 文件名称
     * @param string $key 键值对数组的键值
     * @param string $default
     * @return mixed
     */
    public static function get($file, $key = '', $default = '')
    {
        if (empty($file) || !\is_string($file)) {
            return $default;
        }

        // 查看是否是php文件
        if ($extPos = \strrpos($file, '.php')) {
            $file = \substr($file, 0, $extPos);
        }

        if (isset(self::$container['config'][$file])) {
            return self::$container['config'][$file][$key];
        }

        $config = [];
        $filePath = self::$appPath . 'config/' . $file . '.php';
        if (\file_exists($filePath)) {
            $config = include_once($filePath);
        }

        if (empty($config)) {
            return $default;
        }

        self::$container['config'][$file] = $config;

        $conf =  isset($config[$key]) ? $config[$key] : [];

        return $conf;
    }
}