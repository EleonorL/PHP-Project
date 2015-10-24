<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-10-16
 * Time: 12:32
 */

require_once("model/Entry.php");

class EditView {

    private static $text = "EntryView::Text";
    private static $title = "EntryView::Title";
    private static $message = "EntryView::Message";
    private static $ID = "EntryView::ID";
    private static $save = "EntryView::Save";

    private static $entryLink = "entry";

    private $idValue;

    private $saveSuccess = false;
    private $saveFail = false;

    private static $sessionSaveLocation;
    private static $userSaveLocation;

    public function __construct() {
        self::$sessionSaveLocation = Settings::MESSAGE_SESSION_NAME . Settings::APP_SESSION_NAME;
        self::$userSaveLocation = Settings::USER_SESSION_NAME . Settings::APP_SESSION_NAME;
    }

    private function generateEditForm($message) {
        return "<h2>New Blog Entry</h2>
                <form action='?entry' method='post' enctype='multipart/form-data'>
                    <fieldset>
                    <legend>Write a new blog entry</legend>
                        <p id='".self::$message."'>" .$message. "</p>
                        <label for='".self::$title."'>Title :</label>
					    <input type='' id='".self::$title."' name='".self::$title."'/>
                        <label for='" .self::$ID. "'>Entry nr: " .$this->idValue. "</label>
                        <br>
                        <textarea name='". self::$text ."' id='". self::$text ."' cols='100' rows='20' placeholder='Write something...'></textarea>
                        <br>
                        <input id='submit' type='submit' name='" .self::$save. "' value='Save'>
                        <br>
                    </fieldset>
                </form>";
    }

    public function response() {
        return $this->doEditForm();
    }

    private function doEditForm() {
        $message = "";
        if ($this->userWantsToSave()) {
            if (strlen($this->getText()) < 1)
                $message .= "Entry content cannot be empty. ";
        }
        return $this->generateEditForm($message);
    }

    public function getEntryLink() {
        return '<a href="?'.self::$entryLink.'">Write a new entry</a>';
    }

    public function getStartLink() {
        return '<a href="?">Back to start</a>';
    }

    public function setID($name) {
        if(file_exists(Settings::ENTRYPATH . addslashes($name) . "/index"))
            $this->idValue = file_get_contents(Settings::ENTRYPATH . addslashes($name) . "/index");
    }

    public function saveSuccess() {
        return $this->saveSuccess;
    }

    public function checkForm() {
        return strlen($this->getText()) > 0;
    }

    public function setSaveSuccess() {
        $_SESSION[self::$sessionSaveLocation] = "Saved new entry.";
        unset($_GET[self::$entryLink]);
        $this->saveSuccess = true;

    }

    public function setSaveFail() {
        $this->saveFail = true;
    }

    public function getEntry($name) {
        $text = $this->getTitle() . "\r\n" . $this->getText();
        return new Entry($name, $text, $this->idValue);
    }

    public function userWantsToSave() {
        return isset($_POST[self::$save]);
    }

    private function getTitle() {
        if(isset($_POST[self::$title])) {
            return $_POST[self::$title];
        }
        return "";
    }

    private function getText() {
        if(isset($_POST[self::$text])) {
            return $_POST[self::$text];
        }
        return "";
    }

    public function increaseID($name) {
        if(file_exists(Settings::ENTRYPATH . addslashes($name) . "/index"))
            file_put_contents(Settings::ENTRYPATH . addslashes($name) . "/index", $this->idValue + 1);
        $this->setID($name);
    }

    public function clickedNewEntry() {
        return isset($_GET[self::$entryLink]);
    }

}