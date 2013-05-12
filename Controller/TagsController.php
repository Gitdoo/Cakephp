<?php
Class TagsController extends AppController
{
	var $name = 'Tag';
	
	var $uses = array('Tag','Post','PostTag');

}
?>
