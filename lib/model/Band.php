<?php

class Model_Band
{
    protected $data;

    public function Model_Band($id, $data = array(), $fromId = false)
    {
        if ($fromId)
        {
            $this->data = $data;
            $this->data['id'] = $id;
        }
        else if (preg_match('/^([a-zA-Z0-9]+)$/', $id) != 0)
        {
            $this->data = $data;
            $this->data['id'] = (is_string($id) ? base_convert(strval($id), 36, 10) : $id);
        }
        else
        {
            // TODO : Error 500
        }
    }

    private function fetchData()
    {
        $rs = DB::select
        ('
            SELECT *
            FROM `band`
            WHERE `id`="' . $this->data['id'] . '"
        ');
        if ($rs['total'] == 0)
        {
            // TODO : Error 500
        }
        else
        {
            $this->data = $rs['data'][0];
        }
    }

    private function getData($name = false)
    {
        if (!$this->data || count($this->data) == 0 || !isset($this->data[$name]))
        {
            $this->fetchData();
        }
        if ($name)
        {
            return $this->data[$name];
        }
        else
        {
            return $this->data;
        }
    }

    public function exists()
    {
        return count($this->getData()) == 1 ? false : true;
    }

    public function updateView()
    {
        DB::update
        ('
            UPDATE LOW_PRIORITY `band`
            SET
                `view_count` = `view_count` + 1,
                `view_date` = "' . time() . '"

            WHERE `id` = "' . $this->data['id'] . '"
        ');
    }

    public function getExtendedId()     { return base_convert(strval($this->getId()), 10, 36); }
    public function getId()             { return $this->getData('id'); }
    public function getStatus()         { return $this->getData('status'); }
    public function getPublicStatus()   { return $this->getData('public'); }
    public function getOfficialStatus() { return $this->getData('official'); }
    public function getName()           { return $this->getData('name'); }
    public function getHomepage()       { return $this->getData('homepage'); }
    public function getCreationDate()   { return $this->getData('creation_date'); }
    public function getViewDate()       { return $this->getData('view_date'); }
    public function getViewCount()      { return $this->getData('view_count'); }
    public function getEmail()          { return $this->getData('email'); }
    public function getURL()            { return Conf::get('ROOT_PATH') . $this->getExtendedId(); }

}

