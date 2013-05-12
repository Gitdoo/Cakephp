<html>
<head>
	<title><?php echo $title_for_layout?></title>
	<meta charset="utf-8">
</head>
<body bgcolor=#dddddd>
	<div id="header" style="height:100px;">
	Гостьова Книга!!!
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!
    <br>
		<div id="search" style="float:right;top:50px;">
        <?php echo $this->form->create('Post', array('action' => 'search','method'=>'post'));
            echo $this->form->input('',array( 'name'=>'search', 'type'=>'text'));
            echo "(Дата у форматі yyyy-mm-dd hh:mm:ss)";
            echo $this->form->end('Пошук!');?>
		</div>
	</div>

<div id="conteiner" style="float:left;padding:10px;margin:20px;width:95%;height:auto;">
    	<h1 align="center">Гостьова Книга</h1>
		<h2>
<?php if ($status) echo $this->Html->link('Вийти', '/users/logout');else echo $this->Html->link('Увійти', '/users/login');?>
		</h2>
		<?php  echo $this->Session->flash(); ?>
<div id="content" style="float:left;width:80%;">
<a href="/cakephp/posts" style="float:right;"><h4>Вернутися на головну</h4></a>
<h3>Записи </h3>
<?php echo $this->fetch('content'); ?>  
</div>
</div>
<hr>
<div id="footer" id="height:100px; padding:10px;margin:20px;clear: left;">
	
	Гостьова Книга!!!
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!	
	Гостьова Книга!!! 
	Гостьова Книга!!!
</div>    
</body>
</html>


