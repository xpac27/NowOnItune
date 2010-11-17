<?php

class Page
{
    protected $params;

    public function Page()
    {
        $this->gatherParameterFromRequest();

        if (Conf::get('PROD'))
        {
            Globals::$tpl->assignSection('prod_environement');
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
                Globals::$tpl->assignLoopVar('dev_script_list', array
                (
                    'file' => 'js/' . $file,
                ));
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
        if ($this->getParameter('p') !== false)
        {
            return $this->getParameter('p');
        }
        return 0;
    }

    public function configureView(){}
    public function configureData(){}
}

