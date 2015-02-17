<?php

namespace APP\HELPERS;

class Url extends BaseHelper
{
    /**
     * Generate URL with $path and $params
     *
     * @param string $path
     * @param array $params
     *
     * @return string
     */
    public function generate($path, $params = [])
    {
        $hive = $this->f3->hive();
        $host = $hive['HEADERS']['Host'];
        $url = 'http://'.$host.$path;

        foreach ($params as $param) {
            $url .= $param.'/';
        }

        return $url;

    }
}