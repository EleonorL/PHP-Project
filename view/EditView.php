<?php

/**
 * Created by PhpStorm.
 * User: Eleonor Lagerkrants
 * Date: 2015-10-16
 * Time: 12:32
 */
class EditView {

    private static $title = "EditView::Title";
    private static $text = "EditView::Text";
    private static $message = "EditView::Message";
    private static $ID = "EditView::ID";
    private static $cancel = "EditView::Cancel";
    private static $save = "EditView::Save";

    private static $entryLink = "entry";

    private $idValue = 1;

    private $saveSuccess = false;

    private static $sessionSaveLocation;
    private static $userSaveLocation;

    public function __construct() {
       // self::$sessionSaveLocation = Settings::MESSAGE_SESSION_NAME . Settings::APP_SESSION_NAME;
       // self::$userSaveLocation = Settings::USER_SESSION_NAME . Settings::APP_SESSION_NAME;
    }

    public function response() {
        return $this->doEditForm();
    }

    private function doEditForm() {
        $message = "";
        if ($this->userWantsToSave()) {
            if (strlen($this->getTitle()) > 0)
                $message .= "Title cant be empty";
            if (strlen($this->getText()) > 0)
                $message .= "Entry content cant be empty";
        }
        return $this->generateEditForm($message);
    }

    private function generateEditForm($message) {
        return '<h2>New Blog Entry</h2>
                <form action="?edit" method="post" enctype="multipart/form-data">
                    <fieldset>
                    <legend>Write a new blog entry</legend>
                        <p id="'.self::$message.'">' .$message. '</p>
                        <label for="' .self::$title. '">Title :</label>
                        <input type="text" size="20" name="' .self::$title. '" id="' .self::$title. '" value="">
                        <label for="' .self::$ID. '">ID: ' .$this->idValue. '</label>
                        <tr><td> <input type="hidden" name="type" value="<?php echo $this->idValue; ?>" ></td></tr>
                        <br>
                        <textarea name="text" cols="100" rows="20" placeholder="Write something..."></textarea>
                        <br>
                        <input id="submit" type="submit" name="' .self::$save. '" value="Save">
                        <br>
                    </fieldset>
                </form>';
    }

    public function getEntryLink() {
        return '<a href="?'.self::$entryLink.'">Write a new entry</a>';
    }

    public function getStartLink() {
        return '<a href="?">Back to start</a>';
    }

    public function saveSuccess() {
        return $this->saveSuccess;
    }

    public function checkForm() {
        return strlen($this->getTitle()) > 0 && strlen($this->getText()) > 0;
    }

    public function setSaveSuccess() {
        $this->saveSuccess = true;
    }

    public function getEntry($user) {
        return new Entry($user, $this->getTitle(), $this->getText());
    }

    public function userWantsToSave() {
        return isset($_POST[self::$save]);
    }

    private function getTitle() {
        if(isset($_POST[self::$title])) {
            return $this->idValue . ": " . trim($_POST[self::$title]);
        }
        return "";
    }

    private function getText() {
        if(isset($_POST[self::$text])) {
            return trim($_POST[self::$text]);
        }
        return "";
    }

    public function setUserEntryID($ID) {
        $this->idValue = $ID;
    }

    public function increaseID() {
        $this->idValue++;
    }

    public function clickedNewEntry() {
        return isset($_GET[self::$entryLink]);
    }

}