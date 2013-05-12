<div>
<?php echo $this->form->create('User', array('action' => 'recovery'));?>
    
    
    	<?php echo $this->form->input('password',array('label'=>'Введіть пароль', 'type'=>'password','name'=>'password'));?>
       
    	<?php echo $this->form->input('password2',array('label'=>'Підтвердження пароля', 'type'=>'password','name'=>'password2'));?>
        <?php echo $this->form->input(NULL, array('name'=>'email','value'=>$user['User']['email'], 'type'=>'hidden'))?>
	    <?php echo $this->form->end('Змінити пароль');?>
		
	
</div>
