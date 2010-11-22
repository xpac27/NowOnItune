<?php

class Page_Band extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/top.tpl');
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

        // Configure top block
        $top = new Block_Top();
        $top->configure();

        $band = new Model_Band($_GET['id']);
        $band->updateView();

        Globals::$tpl->assignVar(array
        (
            'band_id'          => $band->getId(),
            'band_name'        => $band->getName(),
            'band_homepage'    => $band->getHomepage(),
            'band_url'         => $band->getURL(),
            'band_url_encoded' => urlencode($band->getURL()),
        ));
    }
}


