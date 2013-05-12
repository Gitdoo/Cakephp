<div>
<?php echo $this->form->create('User', array('action' => 'forgot'));
    
    	 echo $this->form->input('',array('label'=>'Email', 'type'=>'email','name'=>'email'));
         echo $this->form->end('Відіслати');
?>
</div>
