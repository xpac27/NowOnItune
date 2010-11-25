<?php

    class Cache
    {
        // class variables
        static $memcached;
        static $local;

        static function connect()
        {
            self::$memcached = new Memcached();
            self::$memcached->addServer('localhost', 11211);
        }

        static function set($key, $object)
        {
            if (Conf::get('MEMCACHED_ENABLED'))
            {
                if (!self::$memcached)
                {
                    self::connect();
                }
                self::$memcached->add($key, $object, Conf::get('MEMCACHED_DURATION'));
            }
            else
            {
                self::$local[$key] = $object;
            }
        }

        static function get($key)
        {
            if (isset(self::$local[$key]))
            {
                return self::$local[$key];
            }
            else if (Conf::get('MEMCACHED_ENABLED'))
            {
                if (!self::$memcached)
                {
                    self::connect();
                }
                return self::$memcached->get($key);
            }
            return false;
        }
    }

