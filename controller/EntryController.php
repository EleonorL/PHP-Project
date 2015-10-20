<?php

require_once("model/EntryModel.php");
require_once("view/EditView.php");

class EntryController {

    private $user;
    private $editView;
    private $entryModel;

    public function __construct(EditView $editView, EntryModel $entryModel) {
        $this->editView = $editView;
        $this->entryModel = $entryModel;
    }

    public function doEntryControl() {
        $entry = $this->editView->getEntry($this->user);
        if ($this->editView->userWantsToSave() && $this->editView->checkForm()) {
            $this->editView->setSaveSuccess();
            $this->entryModel->saveEntry($entry);
            $this->editView->increaseID();
        }
    }
}