<h1>Всі записи</h1>
<div align='left'>
<br>
   
   
    <div>
    <?php foreach ($posts as $post){ ?>
    <hr>
		<b><u>Назва:</u> </b> <?php echo $post['Post']['name']; ?><br>
		<br><b><u>Короткий текст:</u> </b><?php echo $post['Post']['short_text'];?><br>
		<br><b><u>Повний текст:</u></b><?php echo $post['Post']['long_text']; ?><br>
		<br><b><u>Дата написання:</u></b><?php echo $post['Post']['created'];?>
        
		
		<?php
		 if($post['Post']['modified']!=$post['Post']['created']){
		?>
		<br><b>Дата редагування:</b> <?php echo $post['Post']['modified'];}?> 
		<br>
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
    <div align="center">
    <?php 
	   echo $this->Paginator->first($last = '<<Перша ', $options = array()); 
	   echo $this->Paginator->prev($last = '<Попередня ', $options = array()); 
	   echo $this->Paginator->numbers(array('separator'=>' *** ')); 
	   echo $this->Paginator->next($last = ' Наступна>', $options = array());
	   echo $this->Paginator->last($last = ' Остання>>', $options = array());  
    ?>
    </div>
    <div><?php echo $error; ?></div>
</div>
