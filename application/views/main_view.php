<div class="container">
	<div class="row">
		<button type="button" class="btn btn-dark col-sm" onClick="openAddModal()">Добавить задачу</button>
		<select class="browser-default custom-select col-sm" id="sortSelect">
			<option value="1">Сортировка по имени пользователя ASC</option>
			<option value="2">Сортировка по имени пользователя DESC</option>
			<option value="3">Сортировка по email ASC</option>
			<option value="4">Сортировка по email DESC</option>
			<option value="5">Сортировка по статусу ASC</option>
			<option value="6">Сортировка по статусу DESC</option>
		</select>
		<?php
			session_start();
			if(!empty($_SESSION['admin']) && $_SESSION['admin'] == true){
				echo '<a class="btn btn-dark" href="/login/logout" role="button" id="loginLink">Выйти</a>';
			}else{
				echo '<a class="btn btn-dark" href="/login" role="button" id="loginLink">Авторизация</a>';
			}
		?>
	</div>
</div>

<div id="tasksContainer"></div>

<div class="modal fade" id="addTaskModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLabel">Добавить задачу</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				
				<form action="/main/create" method="post">
					<div class="form-group">
						<label for="usernameInput">Имя пользователя</label>
						<input type="text" class="form-control" id="usernameInput" placeholder="Иван Иванов">
						<div class="alert alert-danger" role="alert" id="alertUsername">
							Заполните поле
						</div>
					</div>
					<div class="form-group">
						<label for="emailInput">Email</label>
						<input type="email" class="form-control" id="emailInput" placeholder="name@example.com">
						<div class="alert alert-danger" role="alert" id="alertEmail">
							Заполните поле
						</div>
					</div>
					<div class="form-group">
						<label for="textInput">Текст задачи</label>
						<textarea class="form-control" id="textInput" rows="3"></textarea>
						<div class="alert alert-danger" role="alert" id="alertText">
							Заполните поле
						</div>
					</div>
				</form>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary" onClick="addTask()">Добавить</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="editTaskModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="ModalLabel">Отредактировать задачу</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form action="/main/edit" method="post">
					<div class="form-group">
						<label for="textInputEdit">Текст задачи</label>
						<textarea class="form-control" id="textInputEdit" rows="3"></textarea>
						<label for="checkStatusEdit">Статус задачи</label>
						<input type="checkbox" id="checkStatusEdit">
					</div>
					<input type="hidden" id="idField"/>
				</form>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
				<button type="button" class="btn btn-primary" onClick="editTask()">Сохранить</button>
			</div>
		</div>
	</div>
</div>

<script>
function openAddModal(){
	$('#usernameInput').val('');
	$('#emailInput').val('');
	$('#textInput').val('');
	$('#alertUsername').hide();
	$('#alertEmail').hide();
	$('#alertText').hide();
	$('#usernameInput').css("border-color", "#ced4da");
	$('#emailInput').css("border-color", "#ced4da");
	$('#textInput').css("border-color", "#ced4da");
	$('#addTaskModal').modal('show');
}
async function addTask(){
	$('#usernameInput').css("border-color", "#ced4da");
	$('#emailInput').css("border-color", "#ced4da");
	$('#textInput').css("border-color", "#ced4da");
	$('#alertUsername').hide();
	$('#alertEmail').hide();
	$('#alertText').hide();
	
	let valid = 1;
	if($('#usernameInput').val()==""){
		$('#usernameInput').css("border-color", "red");
		$('#alertUsername').show();
		valid = 0;
	}
	if(!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($('#emailInput').val())){
		$('#emailInput').css("border-color", "red");
		$('#alertEmail').text('email не валиден');
		$('#alertEmail').show();
		valid = 0;
	}
	if($('#emailInput').val()==""){
		$('#emailInput').css("border-color", "red");
		$('#alertEmail').text('Заполните поле');
		$('#alertEmail').show();
		valid = 0;
	}
	if($('#textInput').val()==""){
		$('#textInput').css("border-color", "red");
		$('#alertText').show();
		valid = 0;
	}
	if(valid == 0){
		return;
	}
	let response = await fetch('/main/create', {
		method: 'POST',
		headers: {
			'Content-Type': 'Content-Type: application/json; charset=UTF-8'
		},
		body: JSON.stringify({
			username: document.getElementById("usernameInput").value, 
			email: document.getElementById("emailInput").value, 
			text: document.getElementById("textInput").value
		})
	});	
	let result = await response.text();
	if(result == 1){
		alert("Успешно добавлено");
	}else{
		alert("При добавлении произошла ошибка");
	}
	$('#addTaskModal').modal('hide');
	getTasks();
}

async function editTask(){
	let response = await fetch('/main/edit', {
		method: 'POST',
		headers: {
			'Content-Type': 'Content-Type: application/json; charset=UTF-8'
		},
		body: JSON.stringify({
			id: document.getElementById("idField").value,
			text: document.getElementById("textInputEdit").value,
			status: ($('#checkStatusEdit').prop('checked')) ? 1 : 0
		})
	});	
	let result = await response.text();
	switch(result){
		case '0':
			alert("При изменении произошла ошибка");
			break;
		case '1':
			alert("Успешно изменено");
			break;
		case '2':
			alert("ошибка доступа. Необходима авторизация");
			break;
		default:
			alert("Неизвестная ошибка");
	}
	$('#editTaskModal').modal('hide');
	getTasks();
}

async function getTasks(i = 1){
	let response = await fetch('/main/get', {
		method: 'POST',
		headers: {
			'Content-Type': 'Content-Type: application/json; charset=UTF-8'
		},
		body: JSON.stringify({
			page: i,
			sort: $('#sortSelect').val()
		})
	});	
	let result = await response.text();
	$('#tasksContainer').html(result);
}

async function openEditModal(id){
	$('#idField').val('');
	$('#textInputEdit').val('');
	$('#checkStatusEdit').prop('checked', false);
	
	let response = await fetch('/main/getid', {
		method: 'POST',
		headers: {
			'Content-Type': 'Content-Type: application/json; charset=UTF-8'
		},
		body: JSON.stringify({
			id: id
		})
	});	
	let result = await response.json();
	$('#idField').val(id);
	$('#textInputEdit').val(result['text']);
	if(result['status'] == 1){
		$('#checkStatusEdit').prop('checked', true);
	}else{
		$('#checkStatusEdit').prop('checked', false);
	}
	
	$('#editTaskModal').modal('show');
}

document.addEventListener('DOMContentLoaded', function() {
	$('#sortSelect').change(function() {
		getTasks();
	});
	getTasks();
});
</script>