<?php

class Remote_Admin_Band_Edit extends Remote
{
    public $AJAXONLY = true;
    protected $requireAuth = true;

    public function configureData()
    {
        if (Tool::isOK($_POST['id']))
        {
            if (isset($_POST['status']))
            {
                DB::update('UPDATE `band` SET `status`="' . $_POST['status'] . '" WHERE `id`="' . $_POST['id'] . '"');
            }

            if (isset($_POST['officialStatus']))
            {
                DB::update('UPDATE `band` SET `official`="' . $_POST['officialStatus'] . '" WHERE `id`="' . $_POST['id'] . '"');
            }
        }
    }
}


