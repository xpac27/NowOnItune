<?php

class Remote_Report extends Remote
{
    public $AJAXONLY = false;

    public function configureData()
    {
        if (!isset($_SESSION['latest_report']) || $_SESSION['latest_report'] < time() - 60*10)
        {
            $headers = "MIME-Version: 1.0\n";
            $headers .= "content-type: text/html; charset=iso-8859-1\n";
            $headers .= "From: ".Conf::get('SITE_NAME')." <".Conf::get('ADMIN_EMAIL').">\n";

            mail (Conf::get('ADMIN_EMAIL'), Conf::get('SITE_NAME') . ' - new report', Conf::get('ROOT_PATH') . $_GET['id'] . ' (' . base_convert(strval($_GET['id']), 36, 10) . ')', $headers);

            $_SESSION['latest_report'] = time();
            $_SESSION['feedback'] = 'Thank you, the page has been reported to us!';
        }
        else
        {
            $_SESSION['feedback'] = 'You cannot report more than once every 10 minutes !';
        }
        header('Location: ' . Conf::get('ROOT_PATH'));
        exit();
    }
}


