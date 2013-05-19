<?php
App::uses('AppModel', 'Model');
/**
 * PostsTag
 * 
 * Клас, який описує модель звязків постів та тегів
 */
class PostsTag extends AppModel {
	public $name = 'PostsTag';
	public $belongsTo = array('Post'=> array(
            'className'    => 'Post',
            'foreignKey'   => 'post_id'
        ),
        'Tag'=> array(
            'className'    => 'Tag',
            'foreignKey'   => 'tag_id'
        )
   );
}
?>
