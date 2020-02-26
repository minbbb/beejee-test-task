<?php
class Controller_Main extends Controller
{
	function __construct(){
		$this->model = new Model_Main();
		$this->view = new View();
	}
	
	function action_index(){
		$this->view->generate('main_view.php', 'template_view.php');
	}
	
	function action_create(){
		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		if($data['text'] == "" || $data['username'] == "" || $data['email'] == ""){
			echo 0;
			return;
		}
		echo $this->model->send_data($data);
	}
	
	function action_get(){
		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		$tasks['data'] = $this->model->get_data($data['page'], $data['sort']);
		$tasks['count'] = $this->model->get_count();
		$this->view->generate('tasks_view.php', 'template_view.php', $tasks);
	}
	
	function action_getid(){
		$postData = file_get_contents('php://input');
		$data = json_decode($postData, true);
		$field = $this->model->getid_data($data['id']);
		echo json_encode(mysqli_fetch_array($field));
	}
	
	function action_edit(){
		session_start();
		if(!empty($_SESSION['admin']) && $_SESSION['admin'] == true){
			$postData = file_get_contents('php://input');
			$data = json_decode($postData, true);
			echo $this->model->edit_data($data);
		}else{
			echo '2';
		}
		
	}
}