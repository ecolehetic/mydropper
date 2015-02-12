<?php

namespace APP\HELPERS;

/**
 * Class Upload
 * @package APP\HELPERS
 */
class Upload extends BaseHelper
{

    /**
     * Init the Folder
     */
    public function __construct()
    {
        parent::__construct();

        $this->url();
    }

    /**
     * Upload a file in the server
     *
     * @param $file
     *
     * @return mixed
     * @throws Exception
     */
    public function save($file)
    {
        $type = stristr($file['type'], '/', true);

        if ($type === 'image') {
            //Upload the file in the repository
            if (!$files = $this->web->receive(function ($file, $formFieldName) {

                $this->checkSize($file['type'], $file['size']);

            }, true, function ($file, $formFieldName) {

                $tab = explode('.', $file);
                $ext = $tab[count($tab) - 1];

                return uniqid() . '.' . $ext;
            })
            ) {
                throw new Exception('Error during upload');
            }

            $tab = explode('/', $file['type']);
            $type = $tab[count($tab) - 1];

            $this->resize(key($files), $type);

            return key($files);

        }
    }


    /**
     * Resize Image
     *
     * @param $file
     * @param $type
     *
     * @return bool
     */
    private function resize($file, $type)
    {
        $img = new \Image($file, true);
        $img->resize($this->f3->get('AVATAR_SIZE'), $this->f3->get('AVATAR_SIZE'));
        $img->save();
        if (file_put_contents($file, $img->dump($type))) {
            return true;
        } else {
            return false;
        }
    }

    /*
     * Check the Size of the Image
     *
     * @param file $fileType
     * @param int $size
     */
    private function checkSize($fileType, $size)
    {
        $type = stristr($fileType, '/', true);
        if ($type === 'image' && $size <= (2 * 1024 * 1024)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Change the folder upload
     */
    private function url()
    {
        if ($this->f3->get('ORGANIZE_UPLOAD') === true) {
            $years = date("Y");
            $month = date("m");
            $day = date("d");

            $this->f3->set('UPLOADS', 'uploads/' . $years . '/' . $month . '/' . $day . '/');
        } else {
            $this->f3->set('UPLOADS', 'uploads/');
        }
    }
}