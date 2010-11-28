<?php

    // VERSION
    $conf['VERSION'] = 000002;

    // LOCATION
    $conf['ROOT_PATH']  = 'http://localhost/NowOnItunes/';
    $conf['ROOT_DIR']   = '/Users/USER_NAME/Sites/nowOnItunes/';
    $conf['MEDIA_PATH'] = 'http://localhost/nowOnItunes/media/';
    $conf['MEDIA_DIR']  = '/Users/USER_NAME/Sites/nowOnItunes/media/';

    // DATABASE
    $conf['DB_NAME']     = 'nowOnItunes';
    $conf['DB_HOST']     = 'localhost';
    $conf['DB_USER']     = 'root';
    $conf['DB_PASS']     = '';
    $conf['DB_PRE']      = '';
    $conf['DB_READONLY'] = false;

    // CACHE
    $conf['CACHE_TIMECOEF']     = 0;
    $conf['MEMCACHED_ENABLED']  = false;
    $conf['MEMCACHED_DURATION'] = 60 * 5;

    // ENV
    $conf['PROD'] = false;
    $conf['ONLINE'] = false;

    // AUTH
    $conf['AUTH_ENABLED']  = false;
    $conf['AUTH_USER']     = '';
    $conf['AUTH_PASSWORD'] = '';

    // EMAIL
    $conf['ADMIN_EMAIL'] = 'someone@something.com';

    // IMAGES
    $conf['BAND_IMAGE_SIZE']   = '725x0';
    $conf['BAND_PREVIEW_SIZE'] = '120x120';

    // CONTENT
    $conf['SITE_NAME']                = utf8_encode ('NowOnItunes');
    $conf['PAGE_TITLE']               = utf8_encode ('Now on iTunes.');
    $conf['PAGE_DESCRIPTION']         = utf8_encode ('Create your own announcement of your presence on iTunes. Like The Beatles, create your own ad campaign and share it with the world! Perfect for Bands, Artists, App Developers, and a lot more...');
    $conf['PAGE_KEYWORDS']            = utf8_encode ('');
    $conf['BANDS_PER_PAGE']           = 12;
    $conf['MAX_SUBMITIONS_PER_HOURS'] = 15;

