<?php
/**
  * Solution for assignment 2
  * @author Daniel Toll
  */

require_once("model/LoginModel.php");
require_once("view/LoginView.php");
require_once("model/EntryModel.php");

class LoginController {

	private $model;
    private $entryModel;
	private $loginView;
    private $editView;
    private $user;
	private $entryController;

	public function __construct(LoginModel $model, LoginView $loginView, EditView $editView, EntryModel $entryModel, EntryController $entryController ) {
		$this->model = $model;
        $this->entryModel = $entryModel;
		$this->loginView =  $loginView;
        $this->editView = $editView;
		$this->entryController = $entryController;
	}

	public function doLoginControl() {
		
		$userClient = $this->loginView->getUserClient();
		if ($this->model->isLoggedIn($userClient)) {
			if ($this->loginView->userWantsToLogout()) {
				$this->model->doLogout();
				$this->loginView->setUserLogout();
				$this->user = "";
			}
		}
		else {
			if ($this->loginView->userWantsToLogin()) {
				$uc = $this->loginView->getCredentials();
				if ($this->model->doLogin($uc) == true) {
					$this->loginView->setLoginSucceeded();
				} else {
					$this->loginView->setLoginFailed();
				}
			}
		}
		$this->model->renew($userClient);
	}
}