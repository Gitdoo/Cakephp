<?php
/**
 * Tags Controller
 * 
 * Клас, який описує Теги
 */
Class TagsController extends AppController
{
	public $name = 'Tags';
	public $uses = array('Tag','Post','PostsTag');
	public $scaffold;
}
?>
