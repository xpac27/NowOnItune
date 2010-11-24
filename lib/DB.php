<?php

    class DB
    {
        // class variables
        static $CON, $execTime, $queryTime, $nbReq;

        // Construct
        static function mysqlDatabase()
        {
            self::$execTime = 0;
            self::$nbReq = 0;
        }

        static function connect()
        {
            if (!self::$CON = @mysql_connect(Conf::get('DB_HOST'), Conf::get('DB_USER'), Conf::get('DB_PASS')))
            {
                echo '<html><head><title>' . Conf::get('PAGE_TITLE') . ' - service unavailable</title></head><body><h1><b>' . Conf::get('PAGE_TITLE') . '</b> is temporarily unavailable.</h1><h2><i>Please come back in a few minutes ...</i></h2></body></html>';
                exit();
            }

            self::query('SET NAMES UTF8', self::$CON);
        }

        static function select_db()
        {
            mysql_select_db(Conf::get('DB_NAME'), self::$CON);
        }

        static function query($query)
        {
            if (!self::$CON)
            {
                self::connect();
                self::select_db();
            }

            self::$nbReq ++;

            return mysql_query($query, self::$CON);
        }

        static function select($query, $from = 0, $max = 0)
        {
            if (preg_match("/^\\s*(select)/i", $query))
            {
                self::$queryTime = (float) array_sum(explode(' ', microtime()));

                $rs = self::query($query);

                self::$queryTime = (float) array_sum(explode(' ', microtime())) - self::$queryTime;
                self::$execTime += self::$queryTime;

                if ($rs)
                {
                    $total = @mysql_num_rows($rs);

                    if ($total > 0 && $from < $total)
                    {
                        @mysql_data_seek($rs, $from);

                        ($max == 0)?
                            $max = $total:
                            NULL;

                        for ($n = 0; $n < $max && $row = @mysql_fetch_assoc($rs); $n ++)
                        {
                            $results[$n] = $row;
                        }

                        return array('data' => $results, 'total' => mysql_num_rows($rs), 'sorted' => $n);
                    }

                    mysql_free_result($rs);
                }

                return array('data' => array(), 'total' => 0, 'sorted' => 0);
            }

            return false;
        }

        static function insert($query)
        {
            if (preg_match("/^\\s*(insert)/i", $query))
            {
                if (Conf::get('DB_READONLY'))
                {
                    return 0;
                }
                else
                {
                    self::query($query);
                    return mysql_insert_id(self::$CON);
                }
            }
            return false;
        }

        static function update($query)
        {
            if (preg_match("/^\\s*(update)/i", $query))
            {
                if (Conf::get('DB_READONLY'))
                {
                    return 0;
                }
                else
                {
                    self::query($query);
                    return mysql_affected_rows(self::$CON);
                }
            }
            return false;
        }

        static function delete($query)
        {
            if (preg_match("/^\\s*(delete)/i", $query))
            {
                if (Conf::get('DB_READONLY'))
                {
                    return 0;
                }
                else
                {
                    self::query($query);
                    return mysql_affected_rows(self::$CON);
                }
            }
            return false;
        }

        static function close()
        {
            if (self::$CON)
            {
                mysql_close(self::$CON);
            }
        }

        static function getTotalQueryTime()
        {
            return self::$queryTime;
        }
    }

?>
