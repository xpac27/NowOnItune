<?php

class Remote_Captcha extends Remote
{
    public $AJAXONLY = false;

    public function configureData()
    {
        $text      = rand(10000,99999);
        $height    = 25;
        $width     = 65;
        $image_p   = imagecreate($width, $height);
        $black     = imagecolorallocate($image_p, 100, 100, 100);
        $white     = imagecolorallocate($image_p, 255, 255, 255);
        $font_size = 14;

        $_SESSION['captcha'] = $text;

        header('Content-Type: image/jpeg');

        imagefill($image_p, 0, 0, $white);
        imagestring($image_p, $font_size, 5, 5, $text, $black);
        imagejpeg($image_p, null, 80);

        exit();
    }
}

