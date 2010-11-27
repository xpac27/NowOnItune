<?php

class Remote_Submit extends Remote
{
    public $AJAXONLY = false;

    public function configureData()
    {
        if (!Tool::isOk($_POST['terms']))
        {
            $_SESSION['warning'] = 'You must agree with our terms of use';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }
        else if (!Tool::isOk($_POST['captcha']) || !Tool::isOk($_POST['band_name']) || !Tool::isOk($_FILES['band_cover']) || !isset($_FILES) || $_FILES['band_cover']['error'] == 4)
        {
            $_SESSION['warning'] = 'You must complet the "brand\'s name", the "brand\'s cover" and email field and fill the captcha !';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }
        else if ($_SESSION['captcha'] != $_POST['captcha'])
        {
            $_SESSION['warning'] = 'Invalid information !';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }

        $_SESSION['count_submition'] = isset($_SESSION['count_submition']) ? $_SESSION['count_submition'] + 1 : 1;
        $_SESSION['latest_submition'] = time();

        if ($_SESSION['count_submition'] >= Conf::get('MAX_SUBMITIONS_PER_HOURS'))
        {
            if ($_SESSION['latest_submition'] > time() - 3600)
            {
                $_SESSION['warning'] = 'You\'re amazingly fast! You\'ll have to come back in one hour to post.';
                header('Location: ' . Conf::get('ROOT_PATH'));
                exit();
            }
            else
            {
                $_SESSION['count_submition'] = 0;
            }
        }

        $size      = getimagesize($_FILES['band_cover']['tmp_name']);
        $stat      = stat($_FILES['band_cover']['tmp_name']);
        $extention = strtolower(preg_replace('#.+\.([a-zA-Z]+)$#isU', '$1', $_FILES['band_cover']['name']));

        if ($size[0] <= 1680 && $size[1] <= 1680 && $stat['size'] <= 460800 ) // 450 * 1024 = 460800
        {
            $id = DB::insert
            ('
                INSERT INTO `band`
                SET
                    `name` = "' . $_POST['band_name'] . '",
                    `homepage` = "' . $_POST['band_homepage'] . '",
                    `creation_date` = "' . time() . '",
                    `ip` = "' . $_SERVER['REMOTE_ADDR'] . '",
                    `view_date` = "' . time() . '"
            ');

            $previewSize     = explode('x', Conf::get('BAND_PREVIEW_SIZE'));
            $destinationSize = explode('x', Conf::get('BAND_IMAGE_SIZE'));

            if ($size[0] < $destinationSize[0] || $size[1] < $destinationSize[1])
            {
                $destinationSize = $size;
            }

            $original = Conf::get('MEDIA_DIR'). 'band/original/' . $id . '.' . $extention;

            move_uploaded_file($_FILES['band_cover']['tmp_name'], $original);

            Tool::redimage($original, Conf::get('MEDIA_DIR') . 'band/' . Conf::get('BAND_PREVIEW_SIZE') . '/' . $id . '.jpg', $previewSize[0], (isset ($previewSize[1])) ? $previewSize[1] : false, true);
            Tool::redimage($original, Conf::get('MEDIA_DIR') . 'band/' . Conf::get('BAND_IMAGE_SIZE') . '/' . $id . '.jpg', $destinationSize[0], (isset ($destinationSize[1])) ? $destinationSize[1] : false, true);
        }
        else
        {
            $_SESSION['feedback'] = 'The file you sent is not valid ! JPG, PNG or GIF, 450KB 1680x1680px max';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }

        header('Location: ' . Conf::get('ROOT_PATH') . 'x' . base_convert(strval($id), 10, 36));
    }
}

