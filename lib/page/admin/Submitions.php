<?php

class Page_Admin_Submitions extends Page
{
    protected $requireAuth = true;

    public function configureView()
    {
        $this->addScript('admin/main.js');
        $this->addStyle('view/admin/submitions.css');

        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/block/menu.tpl');
        Globals::$tpl->assignTemplate('lib/view/admin/submitions.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top menu
        $menu = new Block_Menu();
        $menu->configure();

        $category = new Model_Category();
        $category->setNoCache(true);

        if ($this->hasParameter('filter'))
        {
            $filters = explode('+', $this->getParameter('filter'));
            $bands   = $category->getBands
            (
                'latest',
                $this->getPage(),
                (in_array('online', $filters) ? 1 : null),
                (in_array('public', $filters) ? 1 : null),
                (in_array('official', $filters) ? 1 : null)
            );
            $bandsTotal = $category->getBandsTotal
            (
                (in_array('online', $filters) ? 1 : null),
                (in_array('public', $filters) ? 1 : null),
                (in_array('official', $filters) ? 1 : null)
            );
            Globals::$tpl->assignVar(array
            (
                'filter_online_checked'   => (in_array('online', $filters) ? 'checked="checked"' : ''),
                'filter_public_checked'   => (in_array('public', $filters) ? 'checked="checked"' : ''),
                'filter_official_checked' => (in_array('official', $filters) ? 'checked="checked"' : ''),
            ));
        }
        else
        {
            $bands = $category->getBands();
            $bandsTotal = $category->getBandsTotal();
        }

        Globals::$tpl->assignVar(array
        (
            'bands_total'           => $category->getBandsTotal(),
            'bands_total_online'    => $category->getBandsTotal(1),
            'bands_total_public'    => $category->getBandsTotal(1, 1),
            'bands_total_officials' => $category->getBandsTotal(1, 1, 1),
        ));

        foreach ($bands as $band)
        {
            Globals::$tpl->assignLoopVar('bands', array
            (
                'id'               => $band->getId(),
                'name'             => $band->getName(),
                'homepage'         => $band->getHomepage(),
                'creation_date'    => date('d/m/Y H:i', $band->getCreationDate()),
                'view_count'       => $band->getViewCount(),
                'email'            => $band->getEmail(),
                'url'              => $band->getURL(),
                'online_checked'   => $band->getStatus() ? 'checked="checked"' : '',
                'public_checked'   => $band->getPublicStatus() ? 'checked="checked"' : '',
                'official_checked' => $band->getOfficialStatus() ? 'checked="checked"' : '',
            ));
        }

        if ($bandsTotal > Conf::get('BANDS_PER_PAGE'))
        {
            Globals::$tpl->assignSection('pagination');

            $pagination = new Model_Pagination();
            $pagination->setPage($this->getPage());
            $pagination->setLink('admin/submitions' . ($this->hasParameter('filter') ? '/' . $this->getParameter('filter') : ''));
            $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
            $pagination->setTotalItem($bandsTotal);
            $pagination->compute();
        }
    }
}



