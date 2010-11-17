<?php

class Block
{
    protected $template = '';
    protected $isAjax   = true;

    public function BlocK()
    {
        $this->isAjax = false;
    }

    public function setIsAjax($value = true)
    {
        $this->isAjax = $value;
    }

    public function isAjax()
    {
        return $this->isAjax;
    }

    public function assignTemplate()
    {
        if (!empty($this->template))
        {
            Globals::$tpl->assignTemplate($this->template);
        }
    }

    public function configure(){}
}

