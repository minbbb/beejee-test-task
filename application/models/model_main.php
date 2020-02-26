<?php
class Model_Main extends Model
{
	function query_db($query){
		$link = mysqli_connect('localhost', 'username', 'password', 'database');
		if($link != false){
			mysqli_set_charset($link, "utf8");
			return mysqli_query($link, $query);
		}
	}
	
	public function get_data($i, $sort){
		$sort_text = 'username ASC';
		switch($sort){
			case 1:
				$sort_text = 'username ASC';
				break;
			case 2:
				$sort_text = 'username DESC';
				break;
			case 3:
				$sort_text = 'email ASC';
				break;
			case 4:
				$sort_text = 'email DESC';
				break;
			case 5:
				$sort_text = 'status ASC';
				break;
			case 6:
				$sort_text = 'status DESC';
				break;
		}
		return Model_Main::query_db('SELECT * FROM main ORDER BY '.$sort_text.' LIMIT 3 OFFSET '.($i-1)*3);
	}
	
	public function send_data($arr){
		return Model_Main::query_db('INSERT INTO main(username, email, text) VALUES ("'.addslashes($arr["username"]).'","'.addslashes($arr["email"]).'","'.addslashes($arr["text"]).'")');
	}
	
	public function get_count(){
		return Model_Main::query_db('SELECT COUNT(*) FROM main');
	}
	
	public function getid_data($i){
		return Model_Main::query_db('SELECT * FROM main WHERE id='.$i);
	}
	
	public function edit_data($arr){
		if(mysqli_fetch_array(Model_Main::getid_data($arr['id']))['text'] != $arr['text']){
			return Model_Main::query_db('UPDATE main SET text="'.addslashes($arr['text']).'", status="'.$arr['status'].'", adminStatus="1" WHERE id='.$arr['id']);
		}
		return Model_Main::query_db('UPDATE main SET text="'.addslashes($arr['text']).'", status="'.$arr['status'].'" WHERE id='.$arr['id']);
	}
}