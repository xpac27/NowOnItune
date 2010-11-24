<?php

class Page_Band extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/band.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        if (!Conf::get('ONLINE'))
        {
            header('Location: ' . ROOT_PATH);
            exit();
        }

        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        $band = new Model_Band($_GET['id']);

        if (!$band->exists())
        {
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }
        else if (!$band->getStatus())
        {
            Globals::$tpl->assignSection('offline');
        }
        else
        {
            $band->updateView();

            Globals::$tpl->assignVar(array
            (
                'band_id'          => $band->getId(),
                'band_extendedId'  => $band->getExtendedId(),
                'band_name'        => $band->getName(),
                'band_homepage'    => (preg_match('#^https?+://[A-Za-z0-9-_]+\.[A-Za-z0-9-_%&\?\/.=]+\#?.*$#i', $band->getHomepage()) ? $band->getHomepage() : Conf::get('ROOT_PATH')),
                'band_url'         => $band->getURL(),
                'band_url_encoded' => urlencode($band->getURL()),
            ));

            Globals::$tpl->assignSection('online');
            Globals::$tpl->assignSection('report');

            Globals::$tpl->assignVar ('PAGE_TITLE', $band->getName() . ' - ' . Conf::get('PAGE_TITLE'));
        }
    }
}


