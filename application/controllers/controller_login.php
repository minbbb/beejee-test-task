<?php
session_start();
class Controller_Login extends Controller
{
	function __construct(){
		$this->view = new View();
	}
	
	function action_index(){
		$this->view->generate('login_view.php', 'template_view.php');
	}
	
	function action_login(){
		if($_POST['login'] == 'admin' && $_POST['pass'] == '123'){
			$_SESSION['admin'] = true;
			header('Location: /');
		}else{
			$this->view->generate('login_view.php', 'template_view.php', "Ошибка доступа");
		}
	}
	
	function action_logout(){
		unset($_SESSION['admin']);
		header('Location: /');
	}
}