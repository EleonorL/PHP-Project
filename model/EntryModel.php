<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-10-16
 * Time: 15:41
 */

require_once("model/EntryDAL.php");
require_once("model/Entry.php");

class EntryModel {

    private $entry;
    private $entryDAL;

    private static $sessionEntryLocation = "EntryModel::createNewEntry";

    public function __construct() {
        self::$sessionEntryLocation .= Settings::APP_SESSION_NAME;
        $this->entryDAL = new EntryDAL();
    }

    public function saveEntry(Entry $entry) {
        $this->entry = $entry;
        $this->entryDAL->save($this->entry->getUsername(), $this->entry->getID(), $this->entry->getText());
        $_SESSION[self::$sessionEntryLocation] = $entry;
    }

    public function didSaveEntry() {
        unset($_SESSION[self::$sessionEntryLocation]);
    }

}