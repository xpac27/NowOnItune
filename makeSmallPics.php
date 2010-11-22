<?php

    include 'conf/default.php';
    include 'conf/local.php';
    include 'lib/Tool.php';

    $images = scandir($conf['MEDIA_DIR'] . 'band/original/');

    foreach ($images as $image)
    {
        if ($image != '.' && $image != '..')
        {
            Tool::redimage($conf['MEDIA_DIR'] . 'band/original/' . $image, $conf['MEDIA_DIR'] . 'band/120x120/' . $image, 120, 120);
        }
    }

