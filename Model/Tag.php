<?php
App::uses('Model', 'AppModel');
/**
 * Tag
 * 
 * Клас, який описує модель тегів
 */
class Tag extends AppModel
{
     public $name = 'Tag';
     public $hasMany = array('PostsTag'=> array(
            'className'     => 'PostsTag',
            'foreignKey'    => 'tag_id'
        ),
    );
}
?>
