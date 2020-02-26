<div class="container">
	<?php
		session_start();
		echo '<div class="row head"><div class="col-sm-2">Имя пользователя</div>';
		echo '<div class="col-sm-2">Email</div>';
		echo '<div class="col-sm-5">Текст задачи</div>';
		echo '<div class="col-sm-3">Статус</div></div>';
		foreach($data['data'] as $row){
			echo '<div class="row taskRow"><div class="col-sm-2">'.$row['username'].'</div>';
			echo '<div class="col-sm-2">'.$row['email'].'</div>';
			echo '<div class="col-sm-5"><pre>'.htmlspecialchars($row['text']).'</pre></div>';
			echo '<div class="col-sm-3"><p>'.($row['status']==0 ? 'Не выполнено' : 'Выполнено').'</p>'.($row['adminStatus']==1 ? '<p>Отредактировано администратором</p>' : '').((!empty($_SESSION['admin']) && $_SESSION['admin'] == true) ? ' <button type="button" class="btn btn-dark" onClick="openEditModal('.$row['id'].')">✎</button>' : "").'</div></div>';
		} 
	?>
</div>
<div align="center">
<?php
	$countPage = mysqli_fetch_array($data['count'])[0];
	for($i = 0;$i < $countPage/3; $i++){
		echo '<button type="button" class="btn btn-dark" onClick="getTasks('.($i + 1).');">'.($i + 1).'</button>';
	}
?>
</div>