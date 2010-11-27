<?php

class Model_Search
{
    private $bands     = array();
    private $query     = '';
    private $query_md5 = '';
    private $noCache   = false;

    public function Model_Search($query)
    {
        $this->query     = $query;
        $this->query_md5 = md5($query);
    }

    private function getData()
    {
        if (!$this->noCache)
        {
            return Cache::get('Model_Category::' . $this->query_md5);
        }
        return false;
    }

    private function setData($value)
    {
        if (!$this->noCache)
        {
            Cache::set('Model_Category::' . $this->query_md5, $value);
        }
    }

    private function fetchData()
    {
        if (!$data = $this->getData())
        {
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                WHERE `status` = "1"
                AND CONCAT_WS(" ", b.name, b.homepage) LIKE(\'' . Tool::getLikeList($this->query) . '\')
                ORDER BY b.id DESC
            ');
            $this->setData($data = $rs['data']);
        }
        return $data;
    }

    private function getBandsFromData($data, $from, $max)
    {
        $bands = array();
        foreach (array_slice($data, $from, $max) as $key => $band)
        {
            if (!isset($this->bands[$band['id']]))
            {
                if ($this->noCache)
                {
                    Model_Band::deleteData($band['id']);
                }
                $this->bands[$band['id']] = new Model_Band($band['id'], $band, true);
            }
            $bands[] = $this->bands[$band['id']];
        }
        return $bands;
    }

    public function get($page = false)
    {
        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');

        return $this->getBandsFromData($this->fetchData(), $from, $max);
    }

    public function getTotalResult()
    {
        return count($this->fetchData());
    }

    public function getQuery() { return $this->query; }

    public function setNoCache($value = true) { $this->noCache = $value; }
}



