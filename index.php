<?php

    // CONF
    include 'conf/default.php';
    include 'conf/local.php';
    include 'lib/Conf.php';
    Conf::register($conf);

    // PHP
    ini_set('session.use_trans_sid', '0');    // remove PHPSSID
    ini_set('url_rewriter.tags', '');         // remove PHPSSID
    date_default_timezone_set('Europe/Paris');
    session_start();

    // AUTOLOADER
    function __autoload($className)
    {
        include Conf::get('ROOT_DIR') . 'lib/' . str_replace('_', '/', $className) . '.php';
    }

    class Globals
    {
        static $tpl;

        static function init()
        {
            self::$tpl = new Template();
        }
    }

    Globals::init();

    // TEMPLATE ENGINE
    Globals::$tpl->cacheTimeCoef = Conf::get('CACHE_TIMECOEF');
    Globals::$tpl->assignVar (array(
        'PAGE_TITLE'       => Conf::get('PAGE_TITLE'),
        'PAGE_DESCRIPTION' => Conf::get('PAGE_DESCRIPTION'),
        'PAGE_KEYWORDS'    => Conf::get('PAGE_KEYWORDS'),
        'ROOT_PATH'        => Conf::get('ROOT_PATH'),
        'VERSION'          => Conf::get('VERSION')
    ));

    // DECTECT IF AJAX
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
    {
        $ajax = true;
        Globals::$tpl->assignSection('AJAX');
    }
    else
    {
        $ajax = false;
        Globals::$tpl->assignSection('NOT_AJAX');
    }

    // REMOTES
    if (isset($_GET['remote']))
    {
        $className = Tool::path2class($_GET['remote'], 'Remote');
        $remote    = new $className();
        if ($ajax)
        {
            $remote->configureData();

            if ($remote->AJAXONLY == false)
            {
                $remote->configureView();
                Globals::$tpl->display();
            }
        }
        else
        {
            if ($remote->AJAXONLY == false)
            {
                $page = new Page();
                Globals::$tpl->assignTemplate('lib/view/header.tpl');
                Globals::$tpl->assignTemplate('lib/view/top.tpl');
                $remote->configureData();
                $remote->configureView();
                Globals::$tpl->assignTemplate('lib/view/footer.tpl');
                Globals::$tpl->display();
            }
            else
            {
                // TODO 400
            }
        }
        exit();
    }

    // PAGES
    if (isset($_GET['page']))
    {
        switch ($_GET['page'])
        {
            case 'band':
                $page = new Page_Band();
                break;

            default :
                $page = new Page();
        }
        $page->configureData();
        $page->configureView();

        Globals::$tpl->display();
    }

