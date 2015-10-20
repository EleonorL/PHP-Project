<?php
 /**
  * Solution for assignment 2
  * @author Daniel Toll
  */
require_once("Settings.php");
require_once("controller/LoginController.php");
require_once("controller/RegisterController.php");
require_once("controller/EntryController.php");
require_once("controller/ApplicationController.php");
require_once("view/DateTimeView.php");
require_once("view/LayoutView.php");
require_once("view/RegistrationView.php");
require_once("view/EditView.php");

if (Settings::DISPLAY_ERRORS) {
	error_reporting(-1);
	ini_set('display_errors', 'ON');
}

//session must be started before LoginModel is created
session_start(); 

//Dependency injection
$m = new LoginModel();
$em = new EntryModel();
$v = new LoginView($m);
$rv = new RegistrationView();
$ev = new EditView();
$rc = new RegisterController($rv, $v);
$ec = new EntryController($ev, $em);
$lc = new LoginController($m, $v, $ev, $em, $ec);
$ac = new ApplicationController($lc, $rc, $ec);


//Controller must be run first since state is changed
$ac->doControl();


//Generate output
$dtv = new DateTimeView();
$lv = new LayoutView();
$lv->render($m->isLoggedIn($v->getUserClient()), $v, $dtv, $rv, $ev);

