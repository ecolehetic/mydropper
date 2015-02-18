<?php

namespace APP\HELPERS;

class Url extends BaseHelper
{
    /**
     * Generate URL with $path, GET $params and $admin prefix
     *
     * @param string $path
     * @param array $params
     * $admin bool default FALSE
     *
     * @return string
     */
    public function generate($path, $params = [], $is_admin = false)
    {
        $hive = $this->f3->hive();
        $host = $hive['HEADERS']['Host'];
        if($is_admin){
            $prefix = '/admin';
        }else{
            $prefix = '';
        }

        $url = 'http://'.$host.$prefix.$path;

        foreach ($params as $param) {
            $url .= '/'.$param;
        }

        return $url;

    }

}