<?php

class Model_Band
{
    private $id = null;

    public function Model_Band($id, $data = array(), $fromId = false)
    {
        if (!$fromId)
        {
            $id = (is_string($id) ? base_convert(strval($id), 36, 10) : $id);
        }
        $this->id = $id;

        if (!$this->getData('band_' . $this->id))
        {
            $this->setData('band_' . $this->id, $data);
        }
    }

    private function getData($name)
    {
        return Cache::get('Model_Band::' . $name);
    }

    private function setData($name, $value)
    {
        Cache::set('Model_Band::' . $name, $value);
    }

    private function fetchData($key = false)
    {
        if (!$data = $this->getData('band_' . $this->id))
        {
            $rs = DB::select
            ('
                SELECT *
                FROM `band`
                WHERE `id`="' . $this->id . '"
            ');
            if ($rs['total'] == 0)
            {
                // TODO : Error 500
            }
            else
            {
                $this->setData('band_' . $this->id, $data = $rs['data'][0]);
            }
        }
        return $key ? $data[$key] : $data;
    }

    public function exists()
    {
        return count($this->fetchData()) == 1 ? false : true;
    }

    public function updateView()
    {
        DB::update
        ('
            UPDATE LOW_PRIORITY `band`
            SET
                `view_count` = `view_count` + 1,
                `view_date` = "' . time() . '"

            WHERE `id` = "' . $this->id . '"
        ');
    }

    public function getExtendedId()     { return base_convert(strval($this->getId()), 10, 36); }
    public function getId()             { return $this->fetchData('id'); }
    public function getStatus()         { return $this->fetchData('status'); }
    public function getPublicStatus()   { return $this->fetchData('public'); }
    public function getOfficialStatus() { return $this->fetchData('official'); }
    public function getName()           { return $this->fetchData('name'); }
    public function getHomepage()       { return $this->fetchData('homepage'); }
    public function getCreationDate()   { return $this->fetchData('creation_date'); }
    public function getViewDate()       { return $this->fetchData('view_date'); }
    public function getViewCount()      { return $this->fetchData('view_count'); }
    public function getEmail()          { return $this->fetchData('email'); }
    public function getURL()            { return Conf::get('ROOT_PATH') . $this->getExtendedId(); }

}

