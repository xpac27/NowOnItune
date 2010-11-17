<?php

class Page_Homepage extends Page
{
    public function configureView()
    {
        Globals::$tpl->assignTemplate('lib/view/header.tpl');
        Globals::$tpl->assignTemplate('lib/view/top.tpl');
        Globals::$tpl->assignTemplate('lib/view/homepage.tpl');
        Globals::$tpl->assignTemplate('lib/view/footer.tpl');
    }

    public function configureData()
    {
        // Configure top block
        $top = new Block_Top();
        $top->configure();
    }
}

