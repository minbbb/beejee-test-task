<div class="container col-sm-6">
	<div class="row">
		<form class="col-sm-12" action="/login/login" method="post">
			<div class="form-group">
				<label for="loginInput">Логин</label>
				<input type="text" class="form-control" id="loginInput" name="login" required>
				<label for="passInput">Пароль</label>
				<input type="text" class="form-control" id="passInput" name="pass" required>
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
			<?php echo $data?>
		</form>
	</div>
</div>
