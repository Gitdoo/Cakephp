<h1>Всі Користувачі</h1>
<div align=left>
<br>
   
   
    <div>
    <?php foreach ($users as $user){ ?>
    <hr>
		<b><u>Імя:</u> </b> <?php echo $user['User']['name']; ?><br>
		<br><b><u>Прізвище:</u> </b><?php echo $user['User']['family'];?><br>
		<br><b><u>Email:</u></b><?php echo $user['User']['email']; ?><br>
		<br><b><u>Дата ствррення:</u></b><?php echo $user['User']['created'];?>
		<br>
        <?php 
			
			echo $this->Html->link('Показати інформацію Користувача !' ,'/users/view/'.$user['User']['id']);
			echo "<br>";
            echo $this->Html->link('Видалити Користувача!' ,'/users/delete/'.$user['User']['id']);
			echo "<br>";
         ?>		
		
    <?php } ?>
    </div>
    
    <div><?php echo $error; ?></div>
</div>
