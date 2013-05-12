<?php
App::uses('AppModel', 'Model');

class PostTag extends AppModel {
	$belongsTo = array('Post'=> array(
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
