<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-10-16
 * Time: 15:00
 */
class Entry {

    private $ID;
    private $name;
    private $text;
    public $dal;

    public function __construct($name, $text, $ID) {
        $this->name = $name;
        $this->text = $text;
        $this->ID = $ID;
        $this->dal = new EntryDAL();
    }

    public function saveEntry() {
        return $this->dal->save($this->name, $this->ID, $this->text);
    }

    public function getUsername() {
        return $this->name;
    }

    public function getID() {
        return $this->ID;
    }

    public function getText() {
        return $this->text;
    }

}