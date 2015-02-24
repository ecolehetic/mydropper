<?php

namespace MyDropper\Helpers;

/**
 * Class Url
 * @package MyDropper\Helpers
 */
class Url extends BaseHelper
{
    /**
     * Generate URL with $path, GET $params and $admin prefix
     *
     * @param string $path
     * @param array  $params
     * @param bool   $is_admin
     *
     * @return string
     * @internal param default $bool FALSE $is_admin
     *
     */
    public function generate($path, $params = [], $is_admin = false)
    {
        $hive = $this->f3->hive();
        $host = $hive['HEADERS']['Host'];

        $prefix = ($is_admin) ? '/admin' : '';

        $url = 'http://' . $host . $prefix . $path;

        foreach ($params as $param) {
            $url .= '/' . $param;
        }

        return $url;
    }
}
