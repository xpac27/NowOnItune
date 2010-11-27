<?php

class Page_Random extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/random.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        $category = new Model_Category();

        foreach ($category->getBandsOnlineRandom($this->getPage()) as $key => $band)
        {
            Globals::$tpl->assignLoopVar('bands', array
            (
                'id'         => $band->getId(),
                'name'       => $band->getName(),
                'homepage'   => $band->getHomepage(),
                'view_count' => $band->getViewCount(),
                'url'        => $band->getURL(),
                'pair'       => ($key % 2) ? 'pair' : 'odd',
            ));
        }

        Globals::$tpl->assignVar(array
        (
            'refresh_frequency' => round(Conf::get('MEMCACHED_DURATION') / 60),
        ));

        $pagination = new Model_Pagination();
        $pagination->setPage($this->getPage());
        $pagination->setLink('random');
        $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
        $pagination->setTotalItem($category->getBandsTotalOnline());
        $pagination->compute();
    }
}


