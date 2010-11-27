<?php

class Page_Search extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/search.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        $search = new Model_Search($this->getParameter('query'));

        foreach ($search->get($this->getPage()) as $key => $band)
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
            'search_query' => htmlentities($search->getQuery()),
        ));

        if ($search->getTotalResult() > Conf::get('BANDS_PER_PAGE'))
        {
            Globals::$tpl->assignSection('pagination');

            $pagination = new Model_Pagination();
            $pagination->setPage($this->getPage());
            $pagination->setLink('search/' . urlencode($search->getQuery()));
            $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
            $pagination->setTotalItem($search->getTotalResult());
            $pagination->compute();
        }
    }
}



