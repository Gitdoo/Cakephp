<div>
<h3>Реєстрація</h3>
<?php echo $this->form->create('User', array('action' => 'registration'));?>
			<?php echo 'Прізвище<br>';
			 echo $this->form->input('',array('name'=>'family','type'=>'text'));
			 echo 'Імя<br>';
		     echo $this->form->input('',array('name'=>'name','type'=>'text'));
		     echo 'Email<br>';
		     echo $this->form->input('',array('name'=>'email', 'type'=>'email'));
		     echo 'Пароль<br>';
		     echo $this->form->input('',array('name'=>'password', 'type'=>'password'));
			 echo 'Підтвердження пaроля<br>';
			 echo $this->form->input('',array('name'=>'password2', 'type'=>'password'));
			 if($status['email']==='superadmin@admin.com'){
			 echo 'Створити модератора???<br>';
			 echo $this->form->input('',array('name'=>'moderator', 'type'=>'checkbox','value'=>"true"));
			 }
		 echo $this->form->end('Зареєструватися');?>

</div>
