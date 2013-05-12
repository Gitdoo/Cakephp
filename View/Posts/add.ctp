<div>
	<h3 >Додати запис</h3>
			<?php
			
			echo $this->form->create('Post', array('action' => 'add','method'=>'post'));
			echo "<b>Назва</b><br>";
            echo $this->form->input('',array( 'name'=>'name', 'type'=>'text'));
            echo "<br><b>Короткий текст</b><br>";
			echo $this->form->textarea('',array( 'name'=>'short_text'));
			echo "<br><b>Повний текст</b><br>";
			echo $this->form->textarea('',array( 'name'=>'long_text'));
			echo $this->form->hidden('',array( 'name'=>'user_id', 'value'=>$user['User']['id']));
			echo "<br><b>Теги(розділювач для множинного вводу - ",")</b><br>";
			echo $this->form->textarea('',array( 'name'=>'tags'));
			echo $this->Form->submit('Додати') ?>	
				
</div>
