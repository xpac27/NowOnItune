<?php

class Model_Category
{
    private $bands;
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

    private function fetchBands()
    {
        if (!$data = $this->getData('bands_data'))
        {
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                ORDER BY b.id DESC
            ');
            $this->setData('bands_data', $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsOnline()
    {
        if (!$data = $this->getData('bands_online_data'))
        {
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                WHERE `status` = "1"
                AND `public` = "1"
                ORDER BY b.id DESC
            ');
            $this->setData('bands_online_data', $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsOnlineRandom()
    {
        if (!$data = $this->getData('bands_online_rand_data'))
        {
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                WHERE `status` = "1"
                AND `public` = "1"
                ORDER BY RAND()
            ');
            $this->setData('bands_online_rand_data', $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsTop()
    {
        if (!$data = $this->getData('bands_top_data'))
        {
            $rs = DB::select
            ('
                SELECT b.*
                FROM `band` AS `b`
                WHERE `status` = "1"
                AND `public` = "1"
                ORDER BY b.view_count DESC
            ');
            $this->setData('bands_top_data', $data = $rs['data']);
        }
        return $data;
    }

    private function fetchBandsTotal()
    {
        if (!$data = $this->getData('bands_total'))
        {
            $rs = DB::select('SELECT COUNT(*) as total FROM `band`');
            $this->setData('bands_total', $data = $rs['data'][0]['total']);
        }
        return $data;
    }

    private function fetchBandsTotalOnline()
    {
        if (!$data = $this->getData('bands_total_online'))
        {
            $rs = DB::select('SELECT COUNT(*) as total FROM `band` WHERE `status`="1" AND `public`="1"');
            $this->setData('bands_total_online', $data = $rs['data'][0]['total']);
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

    public function getBandsTotal()
    {
        return $this->fetchBandsTotal();
    }

    public function getBandsTotalOnline()
    {
        return $this->fetchBandsTotalOnline();
    }

    public function getBands($page = false)
    {
        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');

        return $this->getBandsFromData($this->fetchBands(), $from, $max);
    }

    public function getBandsOnline($page = false)
    {
        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');

        return $this->getBandsFromData($this->fetchBandsOnline(), $from, $max);
    }

    public function getBandsOnlineRandom($page = false)
    {
        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');

        return $this->getBandsFromData($this->fetchBandsOnlineRandom(), $from, $max);
    }

    public function getBandsTop($page = false)
    {
        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');

        return $this->getBandsFromData($this->fetchBandsTop(), $from, $max);
    }

    public function setNoCache($value = true) { $this->noCache = $value; }
}


