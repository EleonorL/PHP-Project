<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-10-16
 * Time: 15:01
 */
class EntryDAL {

    public function save($name, $ID, $text) {
        if(file_exists(self::getFileName($name, $ID)))
            return false;
        else {
            file_put_contents(self::getFileName($name, $ID), $text);
            return true;
        }
    }

    public function load($name, $ID) {
        if(file_exists(self::getFileName($name, $ID)))
            return unserialize(file_get_contents(self::getFileName($name, $ID)));
    }

    public function getFileName($name, $ID) {
        $folder = Settings::ENTRYPATH . addslashes($name);
        return $folder . addslashes($ID);
    }

}