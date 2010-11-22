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

        Globals::$tpl->assignVar(array
        (
            'bands_total'        => $category->getBandsTotal(),
            'bands_total_online' => $category->getBandsTotalOnline(),
        ));

        foreach ($category->getBands($this->getPage()) as $band)
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
                'official_checked' => $band->getOfficialStatus() ? 'checked="checked"' : '',
            ));
        }

        $pagination = new Model_Pagination();
        $pagination->setPage($this->getPage());
        $pagination->setLink('admin/submitions');
        $pagination->setItemPerPage(Conf::get('BANDS_PER_PAGE'));
        $pagination->setTotalItem($category->getBandsTotal());
        $pagination->compute();
    }
}



