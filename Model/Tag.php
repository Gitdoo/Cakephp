<?php
App::uses('Model', 'AppModel');
class Tag extends AppModel
{
     public $name = 'Tag';
     public $hasMany = array('PostTag'=> array(
            'className'     => 'Tag',
            'foreignKey'    => 'tag_id'
        )
    );
}
?>
