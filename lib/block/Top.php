<?php

class Block_Top extends Block
{
    public function configure()
    {
        // If a feedback should be displayed
        if (Tool::isOk($_SESSION['feedback']))
        {
            Globals::$tpl->assignSection('feedback');
            Globals::$tpl->assignVar('feedback', $_SESSION['feedback']);
            unset($_SESSION['feedback']);
        }

        // If a warning should be displayed
        if (Tool::isOk($_SESSION['warning']))
        {
            Globals::$tpl->assignSection('warning');
            Globals::$tpl->assignVar('warning', $_SESSION['warning']);
            unset($_SESSION['warning']);
        }
    }
}

