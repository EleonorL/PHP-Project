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
	private $view;
	private $regView;
    private $editView;
    private $user;

	public function __construct(LoginModel $model, LoginView $view, RegistrationView $regView, EditView $editView, EntryModel $entryModel ) {
		$this->model = $model;
        $this->entryModel = $entryModel;
		$this->view =  $view;
		$this->regView = $regView;
        $this->editView = $editView;
	}

	public function doControl() {
		
		$userClient = $this->view->getUserClient();

		if ($this->model->isLoggedIn($userClient)) {
            $this->user = $this->view->getUserName();
			if($this->view->clickedNewEntry()) {
                $entry = $this->editView->getEntry($this->user);
                if ($this->editView->userWantsToSave()) {
                    $this->editView->setSaveSuccess();
                    $this->entryModel->saveEntry($entry);
                }
            }
			if ($this->view->userWantsToLogout()) {
				$this->model->doLogout();
				$this->view->setUserLogout();
                $this->user = "";
			}
		} else {
			if ($this->view->userWantsToLogin()) {
				$uc = $this->view->getCredentials();
				if ($this->model->doLogin($uc) == true) {
					$this->view->setLoginSucceeded();
				} else {
					$this->view->setLoginFailed();
				}
			}

			else if ($this->regView->userWantsToRegister() && $this->regView->checkForm()) {
                $user = $this->regView->getUser();
                if ($user->registerUser() == true) {
					$this->regView->setRegSuccess();
                    $this->view->setUserRegistration();
                }
				else
					$this->regView->setRegFail();
			}
		}
		$this->model->renew($userClient);
	}
}