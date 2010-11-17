<?php

class Model_Band
{
    protected $data;

    public function Model_Band($id, $data = array())
    {
        if (preg_match('/^(\d+)$/', $id) != 0)
        {
            $this->data = $data;
            $this->data['id'] = is_string($id) ? base_convert(strval($id), 36, 10) : $id;
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
            SELECT
                `name`,
                `homepage`,
                `creation_date`,
                `view_date`,
                `view_count`

            FROM `band`
            WHERE `id`="' . $this->data['id'] . '"
        ');
        if ($rs['total'] == 0)
        {
            // TODO : Error 500
        }
        $this->data = $rs['data'][0];
    }

    private function getData($name)
    {
        if (!$this->data || count($this->data) == 0 || !isset($this->data[$name]))
        {
            $this->fetchData();
        }
        return $this->data[$name];
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

    public function getId()           { return $this->getData('id'); }
    public function getName()         { return $this->getData('name'); }
    public function getHomepage()     { return $this->getData('homepage'); }
    public function getCreationDate() { return $this->getData('creation_date'); }
    public function getViewDate()     { return $this->getData('view_date'); }
    public function getViewCount()    { return $this->getData('view_count'); }

}

