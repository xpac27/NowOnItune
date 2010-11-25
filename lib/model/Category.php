<?php

class Model_Category
{
    protected $bands;
    protected $bands_data;
    protected $bands_online_data;
    protected $bands_online_rand_data;
    protected $bands_total;
    protected $bands_total_online;

    public function Model_Category()
    {
    }

    private function fetchBands()
    {
        $rs = DB::select
        ('
            SELECT b.*
            FROM `band` AS `b`
            ORDER BY b.id DESC
        ');
        $this->bands_data = $rs['data'];
    }

    private function fetchBandsOnline()
    {
        $rs = DB::select
        ('
            SELECT b.*
            FROM `band` AS `b`
            WHERE `status` = "1"
            AND `public` = "1"
            ORDER BY b.id DESC
        ');
        $this->bands_online_data = $rs['data'];
    }

    private function fetchBandsOnlineRandom()
    {
        $rs = DB::select
        ('
            SELECT b.*
            FROM `band` AS `b`
            WHERE `status` = "1"
            AND `public` = "1"
            ORDER BY RAND()
        ');
        $this->bands_online_rand_data = $rs['data'];
    }

    private function fetchBandsTotal()
    {
        $rs = DB::select('SELECT COUNT(*) as total FROM `band`');
        $this->bands_total = $rs['data'][0]['total'];
    }

    private function fetchBandsTotalOnline()
    {
        $rs = DB::select('SELECT COUNT(*) as total FROM `band` WHERE `status`="1"');
        $this->bands_total_online = $rs['data'][0]['total'];
    }

    public function getBandsTotal()
    {
        if (!isset($this->bands_total))
        {
            $this->fetchBandsTotal();
        }
        return $this->bands_total;
    }

    public function getBandsTotalOnline()
    {
        if (!isset($this->bands_total_online))
        {
            $this->fetchBandsTotalOnline();
        }
        return $this->bands_total_online;
    }

    public function getBands($page = false)
    {
        if (!isset($this->bands_data))
        {
            $this->fetchBands();
        }

        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');
        $bands = array();

        foreach (array_slice($this->bands_data, $from, $max) as $key => $band)
        {
            if (!isset($this->bands[$band['id']]))
            {
                $this->bands[$band['id']] = new Model_Band($band['id'], $band, true);
            }
            $bands[] = $this->bands[$band['id']];
        }
        return $bands;
    }

    public function getBandsOnline($page = false)
    {
        if (!isset($this->bands_online_data))
        {
            $this->fetchBandsOnline();
        }

        $from  = ((!$page) ? 0 : $page - 1) * Conf::get('BANDS_PER_PAGE');
        $max   = Conf::get('BANDS_PER_PAGE');
        $bands = array();

        foreach (array_slice($this->bands_online_data, $from, $max) as $key => $band)
        {
            if (!isset($this->bands[$band['id']]))
            {
                $this->bands[$band['id']] = new Model_Band($band['id'], $band, true);
            }
            $bands[] = $this->bands[$band['id']];
        }
        return $bands;
    }

    public function getBandsOnlineRandom($max = false)
    {
        if (!isset($this->bands_online_rand_data))
        {
            $this->fetchBandsOnlineRandom();
        }

        $max   = $max ? $max : Conf::get('BANDS_PER_PAGE');
        $bands = array();

        foreach (array_slice($this->bands_online_rand_data, 0, $max) as $key => $band)
        {
            if (!isset($this->bands[$band['id']]))
            {
                $this->bands[$band['id']] = new Model_Band($band['id'], $band, true);
            }
            $bands[] = $this->bands[$band['id']];
        }
        return $bands;
    }
}


