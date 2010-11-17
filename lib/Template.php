<?php

    class Template
    {
        // store the list of all tpl files name and cache time
        var $TEMPLATE, $SECTION, $LOOP, $VARIABLE,    $CONTENT, $SIZE, $LATEST_INCLUDE, $LOOP_SIZE;

        // CONF (could be changed from outside)
        var $cacheFolder, $cacheTimeCoef, $renderCompress, $execTime, $cacheKeyList;

        // Construct
        function Template (){
            $this->TEMPLATE = $this->SECTION = $this->LOOP = $this->VARIABLE = $this->SIZE = $this->LATEST_INCLUDE = $this->LOOP_SIZE = $this->cacheKeyList = array ();
            $this->CONTENT = '';

            // default setings
            $this->cacheFolder = Conf::get('ROOT_DIR') . 'cache/';
            $this->cacheTimeCoef = 1;
            $this->cacheTimeGlobal = 0;
            $this->renderCompress = false;
            $this->renderPreCompress = false;
        }

        // clear all data
        function clear (){
            $this->TEMPLATE = $this->SECTION = $this->LOOP = $this->VARIABLE = $this->SIZE = $this->LATEST_INCLUDE = array ();
            $this->CONTENT = '';
        }

        // clear all you need to make a new render with different tpls
        function clearLayout (){
            $this->TEMPLATE = $this->SIZE = $this->LATEST_INCLUDE = array ();
            $this->CONTENT = '';
        }

        // clear all you need to make a new render with different tpls
        function clearSection (){
            $this->SECTION = array ();
            $this->CONTENT = '';
        }

        // define a custom cache key for a file
        function setCacheKey ($file, $key){
            $this->cacheKeyList[md5($file)] = $key;
        }

        // retunr the number of second since a file was created
        function cacheAge ($cacheName){
            $fp = fopen ($this->cacheFolder.$cacheName, 'r');
            $fstat = fstat ($fp);
            fclose ($fp);

            return time () - $fstat['mtime'];
        }

        // return 1 if we sould use the cache for a tpl or 0 if we sould recompile it
        function cacheVerif ($cacheName, $cache_time){
            $r = false;

            $cache_time *= $this->cacheTimeCoef;

            ($cache_time != 0)?
                (is_dir ($this->cacheFolder))?
                    (file_exists ($this->cacheFolder.$cacheName))?
                        ($this->cacheAge ($cacheName) > ($cache_time * $this->cacheTimeCoef))?
                            unlink ($this->cacheFolder.$cacheName):
                            $r = true:
                        NULL:
                    NULL:
                NULL;

            return $r;
        }

        // set cache files name
        function cacheName ($tpl){
            $md5 = md5($tpl);

            if (array_key_exists($md5, $this->cacheKeyList)){
                return $this->cacheKeyList[$md5].'.html';
            }else{
                //~ $tpl = md5 ($_SERVER['REQUEST_URI']).'-'.md5 ($tpl).'-'.session_id ().'.html':
                return md5 ($_SERVER['REQUEST_URI']).'-'.md5 ($tpl).'.html';
            }
        }

        // add a template
        function assignTemplate ($file, $cache_time = 0){
            ($this->cacheTimeGlobal != 0)?
                $cache_time = $this->cacheTimeGlobal:
                NULL;

            $cacheName = $this->cacheName ($file);
            $useCache = $this->cacheVerif ($cacheName, $cache_time);

            $this->TEMPLATE[] = array ('name' => $file, 'cacheName' => $cacheName, 'useCache' => $useCache, 'cacheTime' => $cache_time);

            if ($useCache){
                return false;
            }

            return true;
        }

        // add a global var
        function assignVar ($var_name, $value = ''){
            if (is_array ($var_name)){
                while (list ($name, $value) = each ($var_name)){
                    $this->VARIABLE[$name] = $value;
                }
            }else{
                $this->VARIABLE[$var_name] = $value;
            }
        }

        // add a section
        function assignSection ($section_name){
            if (is_array ($section_name)){
                while (list ($name) = each ($section_name)){
                    $this->SECTION[$name] = '';
                }
            }else{
                $this->SECTION[$section_name] = '';
            }
        }

        // add a loop
        function assignLoopVar ($loop_name, $vars_array = array ()){
            $this->sizeInc ($loop_name, 1);

            $this->LOOP_SIZE[$loop_name] = (isset ($this->LOOP_SIZE[$loop_name]))?$this->LOOP_SIZE[$loop_name]+1:0;
            //~ echo $loop_name.'</br>';
            $this->LOOP[$this->loopName ($loop_name)][] = $vars_array;
        }

        // count how many times we passed trough each loop (so we can know how deep we are when parsing tpls)
        function sizeInc ($name, $n){
            $levels = explode ('.', $name);
            $size = count ($levels);
            $key = implode('.', array_slice($levels, 0, $size-$n+1));

            ($size > $n - 1)?
                (array_key_exists ($key, $this->SIZE))?
                    $this->SIZE[$key] ++:
                    $this->SIZE[$key] = 0:
                NULL;
        }

        // count how many times we passed trough a loop
        function getSize ($name, $n){
            $levels = explode ('.', $name);
            $size = count ($levels);
            $key = implode('.', array_slice($levels, 0, $size-$n+1));

            return ((array_key_exists ($size-$n, $levels))?((array_key_exists ($key, $this->SIZE))?$this->SIZE[$key]:0):0);
        }

        function sizeReset ($name, $n){
            $levels = explode ('.', $name);
            $size = count ($levels);
            $key = implode('.', array_slice($levels, 0, $size-$n+1));

            ($size > $n - 1)?
                (array_key_exists ($key, $this->SIZE))?
                    $this->SIZE[$key] = 0
                :NULL
            :NULL;
        }

        // return the name of a loop regarding to how deep we are when parsing tpls
        function loopName ($name){
            $level = explode ('.', $name);
            $size = count ($level);
            $result = $level[0];

            $n = count ($level);
            $i = 1;

            $key = implode('.', array_slice($level, 0, $size-1));

            while ($i < $n){
                (array_key_exists ($key, $this->SIZE))?
                    $result .= '.'.$this->SIZE[$key].'.'.$level[$i]:
                    NULL;

                $i ++;
            }

            return $result;
        }

        function getLoopName ($name){
            $levels = explode ('.', $name);

            return (substr ($name, 0, strlen ($name) - (strlen ($levels[count ($levels) - 1]) + 1)));
        }

        // return file content if file exists, nothing if not
        function getFile ($file){
            if (file_exists ($file)){
                $handle = fopen ($file, 'r');
                $file = fread ($handle, filesize ($file));
                fclose ($handle);

                return $file;
            }else{
                return false;
            }
        }

        // compute all templates
        function display ($return = false){
            //print_r($this->SIZE);
            //print_r($this->LOOP);
            $this->execTime = (float) array_sum (explode (' ', microtime ()));

            $this->SIZE = array ();

            while (list ($key, $item) = each ($this->TEMPLATE)){
                if ($item['useCache']){
                    $this->CONTENT .= $this->getFile ($this->cacheFolder.$item['cacheName']);

                    // WARNING : cache used for tpl $item['name']
                }else{
                    $result = ($this->renderPreCompress)?
                        strtr ($this->getFile ($item['name']), array (chr(9) => '', chr(13).chr(10) => '', chr(10) => '')):
                        $this->getFile ($item['name']);

                    $result = $this->section_render ($result);
                    $result = $this->include_render ($result);
                    $result = $this->section_render ($result);
                    $result = $this->variable_render ($result);
                    $result = $this->loop_render ($result);

                    ($this->renderCompress)?
                        $result = strtr ($result, array (chr(9) => '', chr(13).chr(10) => '', chr(10) => '')):
                        NULL;

                    $this->include_saveCache ($result);

                    ($item['cacheTime'] != 0)?
                        $this->saveCache ($item['cacheName'], $result):
                        NULL;

                    $this->CONTENT .= $result;
                }
            }

            $this->execTime = (float) array_sum (explode (' ', microtime ())) - $this->execTime;

            if ($return){
                return $this->CONTENT;
            }else{
                echo $this->CONTENT;
            }
        }

        // save or update a tpl's cache file
        function saveCache ($cacheName, $cacheContent){
            if (is_dir ($this->cacheFolder)){
                $file = fopen ($this->cacheFolder.$cacheName, 'w+');
                fwrite ($file, $cacheContent);
                fclose ($file);
            }
        }

        // include tpls included within tpls
        function include_render ($code){
            preg_match_all ('#<!-- INCLUDE ((.+)\s*(\d*)) -->#isU', $code, $includes);

            $includes = array_unique ($includes[1]);

            while (list ($key, $item) = each ($includes)){
                //in_array ($item, $this->LATEST_INCLUDE)?
                    //NULL:
                    $code = strtr ($code, array ('<!-- INCLUDE '.$item.' -->' => $this->include_exec ($item)));
            }

            //$this->LATEST_INCLUDE = $includes;

            return $code;
        }

        // return include's content
        function include_exec ($name){
            $info = explode (' ', $name);

            if (count ($info) == 2){
                ($this->cacheTimeGlobal != 0)?
                    $info[1] = $this->cacheTimeGlobal:
                    NULL;

                $info[1] *= $this->cacheTimeCoef;

                if ($info[1] != 0){
                    $cacheName = $this->cacheName ($info[0]);
                    $useCache = $this->cacheVerif ($cacheName, $info[1]);

                    if ($useCache){
                        return $this->getFile ($this->cacheFolder.$cacheName);
                    }

                    return '<!-- CACHE '.$cacheName.' -->'.$this->include_render ($this->getFile (Conf::get('ROOT_DIR').$info[0])).'<!-- END '.$cacheName.' -->';
                }
            }

            return $this->include_render ($this->getFile (Conf::get('ROOT_DIR').$info[0]));
        }

        // save the cache of an included file
        function include_saveCache ($code){
            preg_match_all ('#<!-- CACHE (.+) -->(.*)<!-- END \1 -->#isU', $code, $caches);

            while (list ($key, $item) = each ($caches[1])){
                $this->saveCache ($item, $caches[2][$key]);
            }
        }

        // check if template is cached
        function isCached ($file, $time){
            return $this->cacheVerif ($this->cacheName ($file), $time);
        }

        // keep only defined sections
        function section_render ($code){
            preg_match_all ('#<!-- SECTION (.+) -->(.*)<!-- END \1 -->#isU', $code, $matches);

            $sections = array_unique ($matches[1]);

            while (list ($key, $item) = each ($sections)){
                $code = preg_replace (
                    '#<!-- SECTION '.$item.' -->(.*)<!-- END '.$item.' -->#isU',
                    $this->section_exec ($item, $matches[2][$key]),
                    $code,
                    1
                );

                $code = $this->section_render ($code);
            }

            return $code;
        }

        // check if a section exists, return it's content if yes or nothing if not
        function section_exec ($name, $content){
            (array_key_exists ($name, $this->SECTION))?
                NULL:
                $content = false;

            return $content;
        }

        // find first layer loops
        function loop_render ($code){
            if (preg_match_all ('#<!-- LOOP (.+) -->(.*)<!-- END \1 -->#isU', $code, $loops)){
                $this->sizeInc ($loops[1][0], 2);


                while (list ($key, $loop_name) = each ($loops[1])){
                    $result = $this->loop_exec ($loop_name, $loops[2][$key]);

                    $code = preg_replace (
                        '#<!-- LOOP '.$loop_name.' -->(.*)<!-- END '.$loop_name.' -->#isU',
                        $result,
                        $code, 1
                    );
                }
            }

            return $code;
        }

        // compute all loop's variables and try to find new first layer loops within this loop's content
        function loop_exec ($name, $content){
            $result = '';

            $loop_name = $this->loopName ($name);
            $loop_originalName = $this->getLoopName ($name);

            if (array_key_exists ($loop_originalName, $this->LOOP_SIZE)){
                if ($this->LOOP_SIZE[$loop_originalName] < $this->getSize ($loop_name, 3)){


                    $this->sizeReset ($name, 2);

                    $loop_name = $this->loopName ($name);

                    //~ echo $name.' <b>reset</b><br></br>';

                    //~ $this->loop_exec ($name, $content);
                }
            }

            if (array_key_exists ($loop_name, $this->LOOP)){
                preg_match_all ('/#{'.$name.'\.([^\.]*)}/isU', $content, $variables);
                $variables = array_unique ($variables[1]);

                reset ($this->LOOP[$loop_name]);

                while (list ($key_row, $row) = each ($this->LOOP[$loop_name])){
                    //~ echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$loop_name.'<br></br>';

                    $block = $content;

                    reset ($variables);

                    while (list ($key_var, $var) = each ($variables)){
                        (array_key_exists ($var, $this->LOOP[$loop_name][$key_row]))?
                            $block = strtr ($block, array ('#{'.$name.'.'.$var.'}' => $this->LOOP[$loop_name][$key_row][$var])):
                            $block = strtr ($block, array ('#{'.$name.'.'.$var.'}' => ''));
                    }

                    $result .= $this->loop_render ($this->include_render ($block));
                }
            }

            return $result;
        }

        // look for all variables
        function variable_render ($code){
            preg_match_all ('/#{([^\.]*)}/isU', $code, $variables);

            while (list ($key, $item) = each ($variables[1])){
                $code = strtr ($code, array ('#{'.$item.'}' => $this->variable_exec ($item)));
            }

            return $code;
        }

        // return the global variable or nothing
        function variable_exec ($name){
            (array_key_exists ($name, $this->VARIABLE))?
                $name = $this->VARIABLE[$name]:
                $name = false;

            return $name;
        }
    }

?>
