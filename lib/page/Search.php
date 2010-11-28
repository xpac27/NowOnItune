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

        if (strlen($this->getParameter('query')) < 3)
        {
            Globals::$tpl->assignSection('bad_query');
        }
        else
        {
            $this->search();
        }
    }

    private function search()
    {
        $search = new Model_Search($this->getParameter('query'));

        foreach ($search->getBands($this->getPage(), 1, 1) as $key => $band)
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
            'search_query'         => htmlentities($search->getQuery()),
            'search_total_results' => htmlentities($search->getBandsTotal(1, 1)),
        ));

        if ($search->getBandsTotal(1, 1) > Conf::get('BANDS_PER_PAGE'))
        {
            Globals::$tpl->assignSection('pagination');

            $pagination = new Model_Pagination();
            $pagination->setPage($this->getPage());
            $pagination->setLink('search/' . urlencode($search->getQuery()));
            $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
            $pagination->setTotalItem($search->getBandsTotal(1, 1));
            $pagination->compute();
        }

        if ($search->getBandsTotal(1, 1) == 0)
        {
            Globals::$tpl->assignSection('no_results');
        }
        else
        {
            Globals::$tpl->assignSection('search_results');
        }
    }
}



