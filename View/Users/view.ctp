<div>
<hr>
		
		<b><u>Імя:</u> </b> <?php echo $user['User']['name']; ?><br>
		<br><b><u>Прізвище:</u> </b><?php echo $user['User']['family'];?><br>
		<br><b><u>Email:</u></b><?php echo $user['User']['email']; ?><br>
		<br><b><u>Дата ствррення:</u></b><?php echo $user['User']['created'];?>
		<br>
		
		<div id="posts">
		<?php 
			foreach ($posts as $post){ 
				echo "<div>";
				echo $this->Html->link($post['Post']['name'] ,'/posts/view/'.$post['Post']['id']);
				echo "</div>";
			}
		?>
		</div>
</div>
