<div>
<h2>Ви можете тільки переглядати записи,Авторизуйтесь</h2>
   <?php echo $this->form->create('User', array('action' => 'login'));?>
    
    	<?php echo $this->form->input('',array('label'=>'Email  ','type'=>'email','name'=>'email'));?>
    	    
    	<?php echo $this->form->input('',array('label'=>'Пароль', 'type'=>'password','name'=>'password'));?>
	
    	<?php echo $this->form->end('вВІЙТИ');echo "<br><br>";?><? echo $this->HTML->link('Забули пароль?', '/users/forgot'); ?>
    	<? echo $this->HTML->link('Зареєструватися', '/users/registration'); ?>
</div>  


