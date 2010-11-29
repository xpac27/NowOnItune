<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/homepage.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        Globals::$tpl->assignVar(array(
            'band_name'     => Tool::isOk($_SESSION['band_name']) ? htmlspecialchars($_SESSION['band_name']) : 'Band, App, Name...',
            'band_homepage' => Tool::isOk($_SESSION['band_homepage']) ? htmlspecialchars($_SESSION['band_homepage']) : 'iTunes Account Recommended',
            'band_email'    => Tool::isOk($_SESSION['band_email']) ? htmlspecialchars($_SESSION['band_email']) : 'Awesome@mail.com',
        ));

        self::unsetBandFormSessionData();
    }

    static public function unsetBandFormSessionData()
    {
        unset($_SESSION['band_name']);
        unset($_SESSION['band_homepage']);
        unset($_SESSION['band_email']);
    }

    static public function setBandFormSessionData()
    {
        if (Tool::isOk($_POST))
        {
            $_SESSION['band_name']     = $_POST['band_name'];
            $_SESSION['band_homepage'] = $_POST['band_homepage'];
            $_SESSION['band_email']    = $_POST['band_email'];
        }
    }
}
