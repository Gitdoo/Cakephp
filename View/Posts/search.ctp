<h1>Пошук</h1>

<div align=left>
<br>
<h2>Всі записи</h2>
<div align=left>
<br>
   
   
    <div>
    <?php foreach ($posts as $post){ ?>
    <hr>
		<b><u>Назва:</u> </b> <?php echo $post['Post']['name']; ?><br>
		<br><b><u>Короткий текст:</u> </b><?php echo $post['Post']['short_text'];?><br>
		<br><b><u>Повний текст:</u></b><?php echo $post['Post']['long_text']; ?><br>
		<br><b><u>Дата написання:</u></b><?php echo $post['Post']['created'];?>
        <br><b><u>Теги:</u></b><?php //echo $post['Post']['tags'];?>
		
		<?php
		 if($post['Post']['modified']!=$post['Post']['created']){
		?>
		<div><br><b>Дата редагування:</b> <?php echo $post['Post']['modified'];}?> </div> 
		 
		 <?php 
			echo $this->Html->link('Редагувати!' ,'/posts/edit/'.$post['Post']['id']);
			echo "<br>";
			echo $this->Html->link('Показати!' ,'/posts/view/'.$post['Post']['id']);
			echo "<br>";
            echo $this->Html->link('Видалити!' ,'/posts/delete/'.$post['Post']['id']);
			echo "<br>";
         ?>		
		
    <?php } ?>
    </div>
    
    <div><?php echo $error; ?></div>
</div>
</div>
