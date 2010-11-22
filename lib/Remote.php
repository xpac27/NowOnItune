<?php

class Remote
{
    public $AJAXONLY = true;
    protected $requireAuth = false;

    public function Remote()
    {
        if ($this->requireAuth)
        {
            Tool::requireAuth();
        }
    }

    public function configureView(){}
    public function renderData(){}
}


