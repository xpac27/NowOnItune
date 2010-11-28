<?php

    define('START_TIME', microtime(true));

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
        $classPath = explode('_', $className);
        $file = 'lib';
        foreach ($classPath as $key => $segment)
        {
            if ($key == count($classPath) - 1)
            {
                $file .= '/' . $segment;
            }
            else
            {
                $file .= '/' . lcfirst($segment);
            }
        }
        include Conf::get('ROOT_DIR') . $file . '.php';
    }

    // GLOBALS
    class Globals
    {
        static $tpl;

        static function init()
        {
            self::$tpl = new Template();
        }
    }
    Globals::init();

    // STATS
    function addStatsHeaders()
    {
        header('X-MySQL_Stats: ' . number_format(DB::$totalQueryTime, 3) . ' sc (nb ' . DB::$totalQuery . ')');
        header('X-PHP_Stats: ' . number_format(microtime(true) - START_TIME, 3) . ' sc (tpl ' . number_format(Globals::$tpl->execTime, 3) . 'sc)');
    }

    // AUTH
    if (Conf::get('AUTH_ENABLED'))
    {
        Tool::requireAuth();
    }

    // TEMPLATE ENGINE
    Globals::$tpl->cacheTimeCoef = Conf::get('CACHE_TIMECOEF');
    Globals::$tpl->assignVar (array(
        'PAGE_TITLE'       => Conf::get('PAGE_TITLE'),
        'PAGE_DESCRIPTION' => Conf::get('PAGE_DESCRIPTION'),
        'PAGE_KEYWORDS'    => Conf::get('PAGE_KEYWORDS'),
        'ROOT_PATH'        => Conf::get('ROOT_PATH'),
        'MEDIA_PATH'       => Conf::get('MEDIA_PATH'),
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
                Globals::$tpl->compute();
                addStatsHeaders();
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
                Globals::$tpl->compute();
                addStatsHeaders();
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
    if (!Conf::get('ONLINE'))
    {
        $_GET['page'] = 'wait';
    }
    if (isset($_GET['page']))
    {
        switch ($_GET['page'])
        {
            case 'homepage':
                $page = new Page_Homepage();
                break;

            case 'band':
                $page = new Page_Band();
                break;

            case 'top':
                $page = new Page_Top();
                break;

            case 'latest':
                $page = new Page_Latest();
                break;

            case 'random':
                $page = new Page_Random();
                break;

            case 'official':
                $page = new Page_Official();
                break;

            case 'search':
                $page = new Page_Search();
                break;

            case 'wait':
                $page = new Page_Wait();
                break;

            case 'terms':
                $page = new Page_Terms();
                break;

            case 'admin_submitions':
                $page = new Page_Admin_Submitions();
                break;

            default :
                $page = new Page();
        }
        $page->configureData();
        $page->configureView();

        Globals::$tpl->compute();
        addStatsHeaders();
        Globals::$tpl->display();
    }
    else
    {
        // TODO 404
    }

    DB::close();

