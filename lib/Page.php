<?php

class Page
{
    protected $params;
    protected $requireAuth = false;

    public function Page()
    {
        if ($this->requireAuth)
        {
            Tool::requireAuth();
        }

        $this->gatherParameterFromRequest();

        if (Conf::get('PROD'))
        {
            $this->addScript('_prod/lib.js');
            $this->addScript('_prod/base.js');
        }
        else
        {
            $files = array();
            foreach (scandir(Conf::get('ROOT_DIR') . 'js/lib') as $file)
            {
                if (preg_match('/(\.js)$/i', $file))
                {
                    $files[] = 'lib/' . $file;
                }
            }
            foreach (scandir(Conf::get('ROOT_DIR') . 'js') as $file)
            {
                if (preg_match('/(\.js)$/i', $file))
                {
                    $files[] = $file;
                }
            }
            if (file_exists(Conf::get('ROOT_DIR') . 'js/order.json'))
            {
                $order = json_decode(file_get_contents(Conf::get('ROOT_DIR') . 'js/order.json'));
                $n = 0;
                foreach ($order as $file)
                {
                    $key = array_search($file, $files);
                    if ($key !== false)
                    {
                        $item = $files[$n];
                        $files[$n] = $file;
                        $files[$key] = $item;
                        $n ++;
                    }
                }
            }
            foreach ($files as $file)
            {
                $this->addScript($file);
            }
        }
    }

    private function gatherParameterFromRequest()
    {
        $this->params = array();
        foreach ($_GET as $key => $value)
        {
            $this->params[$key] = $value;
        }
    }

    protected function addScript($file)
    {
        Globals::$tpl->assignLoopVar('script_list', array
        (
            'file' => $file,
        ));
    }

    protected function addStyle($file)
    {
        Globals::$tpl->assignLoopVar('style_list', array
        (
            'file' => $file,
        ));
    }

    protected function getParameter($name)
    {
        if (array_key_exists($name, $this->params))
        {
            return $this->params[$name];
        }
        return false;
    }

    protected function getPage()
    {
        if ($this->getParameter('p'))
        {
            return $this->getParameter('p');
        }
        return 1;
    }

    public function configureView(){}
    public function configureData(){}
}

