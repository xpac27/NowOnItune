<?php

class Conf
{
    static $conf;

    public function Conf()
    {
    }

    static function register($conf)
    {
        Conf::$conf = $conf;
    }

    static function get($key)
    {
        return Conf::$conf[$key];
    }
}


