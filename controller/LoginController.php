<?php
/**
  * Solution for assignment 2
  * @author Daniel Toll
  */

require_once("model/LoginModel.php");
require_once("view/LoginView.php");

class LoginController {

	private $model;
	private $loginView;
    private $entryView;
	private $entryController;

	public function __construct(LoginModel $model, LoginView $loginView, EditView $entryView, EntryController $entryController ) {
		$this->model = $model;
		$this->loginView =  $loginView;
        $this->entryView = $entryView;
		$this->entryController = $entryController;
	}

	public function doLoginControl() {
		
		$userClient = $this->loginView->getUserClient();
		if ($this->model->isLoggedIn($userClient)) {
			if ($this->loginView->userWantsToLogout()) {
				$this->model->doLogout();
				$this->loginView->setUserLogout();
			}
		}
		else {
			if ($this->loginView->userWantsToLogin()) {
				$uc = $this->loginView->getCredentials();
				if ($this->model->doLogin($uc) == true) {
                    $name = $uc->getName();
                    $this->loginView->setSessionName($name);
					$this->loginView->setLoginSucceeded();
				} else {
					$this->loginView->setLoginFailed();
				}
			}
		}
		$this->model->renew($userClient);
	}
}