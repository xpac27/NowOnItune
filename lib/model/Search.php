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

    private function getData($name)
    {
        if (!$this->noCache)
        {
            return Cache::get('Model_Search::' . $name);
        }
        return false;
    }

    private function setData($name, $value)
    {
        if (!$this->noCache)
        {
            Cache::set('Model_Search::' . $name, $value);
        }
    }

    private function fetchBands($filters = array())
    {
        $key = md5(print_r($filters, true));

        if (!$data = $this->getData($this->query_md5 . '_' . $key))
        {
            foreach ($filters as $filter => $value)
            {
                $where = (isset($where) ? $where . ' AND ' : ' AND ') . $filter . '="' . $value . '"';
            }
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                WHERE CONCAT_WS(" ", b.name, b.homepage) LIKE(\'' . Tool::getLikeList($this->query) . '\')
                ' . (isset($where) ? $where : '') . '
            ');
            $this->setData($this->query_md5 . '_' . $key, $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsTotal($filters = array())
    {
        $key = md5(print_r($filters, true));

        if (!$data = $this->getData($this->query_md5 . '_total_' . $key))
        {
            foreach ($filters as $filter => $value)
            {
                $where = (isset($where) ? $where . ' AND ' : ' AND ') . $filter . '="' . $value . '"';
            }
            $rs = DB::select
            ('
                SELECT COUNT(*) as total
                FROM `band` AS `b`
                WHERE CONCAT_WS(" ", b.name, b.homepage) LIKE(\'' . Tool::getLikeList($this->query) . '\')
                ' . (isset($where) ? $where : '') . '
            ');
            $this->setData($this->query_md5 . '_total_', $data = $rs['data'][0]['total']);
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

    public function getBands($page = false, $status = null, $public = null, $official = null)
    {
        $filters = array();
        $from    = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max     = Conf::get('BANDS_PER_PAGE');

        if ($status !== null)   { $filters['b.status'] = $status; }
        if ($public !== null)   { $filters['b.public'] = $public; }
        if ($official !== null) { $filters['b.official'] = $official; }

        return $this->getBandsFromData($this->fetchBands($filters), $from, $max);
    }

    public function getBandsTotal($status = null, $public = null, $official = null)
    {
        $filters = array();

        if ($status !== null)   { $filters['b.status'] = $status; }
        if ($public !== null)   { $filters['b.public'] = $public; }
        if ($official !== null) { $filters['b.official'] = $official; }

        return $this->fetchBandsTotal($filters);
    }

    public function getQuery() { return $this->query; }

    public function setNoCache($value = true) { $this->noCache = $value; }
}



