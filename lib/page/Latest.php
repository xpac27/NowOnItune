<?php

class Page_Latest extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/latest.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        $category = new Model_Category();

        foreach ($category->getBands('latest', $this->getPage(), 1, 1) as $key => $band)
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

        $pagination = new Model_Pagination();
        $pagination->setPage($this->getPage());
        $pagination->setLink('latest');
        $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
        $pagination->setTotalItem($category->getBandsTotal(1, 1));
        $pagination->compute();
    }
}


