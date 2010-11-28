<?php

class Model_Category
{
    private $bands   = array();
    private $noCache = false;

    static function deleteData($id)
    {
        // TODO
    }

    public function Model_Category()
    {
    }

    private function getData($name)
    {
        if (!$this->noCache)
        {
            return Cache::get('Model_Category::' . $name);
        }
        return false;
    }

    private function setData($name, $value)
    {
        if (!$this->noCache)
        {
            Cache::set('Model_Category::' . $name, $value);
        }
    }

    private function fetchBands($filters = array(), $order = 'id DESC')
    {
        $key = md5(print_r($filters, true) . $order);

        if (!$data = $this->getData('bands_data_' . $key))
        {
            foreach ($filters as $filter => $value)
            {
                $where = (isset($where) ? $where . ' AND ' : 'WHERE ') . $filter . '="' . $value . '"';
            }
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                ' . (isset($where) ? $where : '') . '
                ORDER BY ' . $order . '
            ');
            $this->setData('bands_data_' . $key, $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsTotal($filters = array())
    {
        $key = md5(print_r($filters, true));

        if (!$data = $this->getData('bands_total_' . $key))
        {
            foreach ($filters as $filter => $value)
            {
                $where = (isset($where) ? $where . ' AND ' : 'WHERE ') . $filter . '="' . $value . '"';
            }
            $rs = DB::select
            ('
                SELECT COUNT(*) as total
                FROM `band` AS `b`
                ' . (isset($where) ? $where : '') . '
            ');
            $this->setData('bands_total_' . $key, $data = $rs['data'][0]['total']);
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

    public function getBandsTotal($status = null, $public = null, $official = null)
    {
        $filters = array();

        if ($status !== null)   { $filters['b.status'] = $status; }
        if ($public !== null)   { $filters['b.public'] = $public; }
        if ($official !== null) { $filters['b.official'] = $official; }

        return $this->fetchBandsTotal($filters);
    }

    public function getBands($sort = 'latest', $page = null, $status = null, $public = null, $official = null)
    {
        $order   = '';
        $filters = array();
        $from    = (($page === null) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max     = Conf::get('BANDS_PER_PAGE');

        if ($status !== null)   { $filters['b.status'] = $status; }
        if ($public !== null)   { $filters['b.public'] = $public; }
        if ($official !== null) { $filters['b.official'] = $official; }

        switch ($sort)
        {
            case 'latest': $order = 'b.id DESC';
                break;
            case 'random': $order = 'RAND()';
                break;
            case 'top'   : $order = 'b.view_count DESC';
                break;
        }

        return $this->getBandsFromData($this->fetchBands($filters, $order), $from, $max);
    }

    public function setNoCache($value = true) { $this->noCache = $value; }
}


