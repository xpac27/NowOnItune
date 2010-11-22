<?php

class Remote_Submit extends Remote
{
    public $AJAXONLY = false;

    public function configureData()
    {
        if (!Tool::isOk($_POST['terms']))
        {
            $_SESSION['feedback'] = 'You must agree with our therms of use';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }
        else if (!Tool::isOk($_POST['captcha']) || !Tool::isOk($_POST['band_name']) || !isset($_FILES) || !Tool::isOk($_FILES['band_cover']) || $_FILES['band_cover']['error'] == 4)
        {
            $_SESSION['feedback'] = 'You must complet the "brand\'s name" and the "brand\'s cover" field and fill the captcha !';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }
        else if ($_SESSION['captcha'] != $_POST['captcha'])
        {
            $_SESSION['feedback'] = 'Invalid information !';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }

        $size      = filesize($_FILES['band_cover']['tmp_name']);
        $stat      = stat($_FILES['band_cover']['tmp_name']);
        $extention = strtolower(preg_replace('#.+\.([a-zA-Z]+)$#isU', '$1', $_FILES['band_cover']['name']));

        if ($size[0] <= 1680 && $size[1] <= 1680 && $stat['size'] <= 450 * 1024)
        {
            $id = DB::insert
            ('
                INSERT INTO `band`
                SET
                    `name` = "' . $_POST['band_name'] . '",
                    `homepage` = "' . $_POST['band_homepage'] . '",
                    `creation_date` = "' . time() . '",
                    `view_date` = "' . time() . '"
            ');

            $destinationSize = explode('x', Conf::get('BAND_IMAGE_SIZE'));

            if ($size[0] < $destinationSize[0] || $size[1] < $destinationSize[1])
            {
                $destinationSize = $size;
            }

            $original = Conf::get('MEDIA_DIR'). 'band/original/' . $id . '.' . $extention;

            move_uploaded_file($_FILES['band_cover']['tmp_name'], $original);

            Tool::redimage($original, Conf::get('MEDIA_DIR') . 'band/' . Conf::get('BAND_IMAGE_SIZE') . '/' . $id . '.jpg', $destinationSize[0], (isset ($destinationSize[1])) ? $destinationSize[1] : false, true);
        }
        else
        {
            $_SESSION['feedback'] = 'The file you sent is not valid ! JPG, PNG or GIF, 450KB 1680x1680px max';
            header('Location: ' . Conf::get('ROOT_PATH'));
            exit();
        }

        header('Location: ' . Conf::get('ROOT_PATH'). base_convert(strval($id), 10, 36));
    }
}

