<?php

class Model_Category
{
    protected $bands;
    protected $bands_data;
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
            if (!isset($this->bands[($key + $from)]))
            {
                $this->bands[($key + $from)] = new Model_Band($band['id'], $band);
            }
            $bands[] = $this->bands[($key + $from)];
        }
        return $bands;
    }
}


