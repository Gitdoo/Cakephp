<div>

		<h3>Редагуйте запис</h3>
		<?php
			echo $this->form->create('Post', array('action' => 'edit/'.$post['Post']['id'],'method'=>'post'));
			echo "<b>Назва</b><br>";
            echo $this->form->input('',array( 'name'=>'name', 'type'=>'text','value'=>$post['Post']['name']));
            echo "<br><b>Короткий текст</b><br>";
			echo $this->form->textarea('',array( 'name'=>'short_text','value'=>$post['Post']['short_text']));
			echo "<br><b>Повний текст</b><br>";
			echo $this->form->textarea('',array( 'name'=>'long_text','value'=>$post['Post']['long_text']));
			echo $this->form->hidden('',array( 'name'=>'user_id','value'=>$post['Post']['user_id']));
			echo "<br><b>Теги(розділювач для множинного вводу - ",")</b><br>";
			echo $this->form->textarea('',array( 'name'=>'tags'));
			echo $this->Form->submit('Редагувати') ?>
		
		
</div>
