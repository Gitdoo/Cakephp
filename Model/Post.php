<?php
App::uses('Model', 'AppModel');
class Post extends AppModel
{
     public $name = 'Post';
   public $hasMany = array(
		'PostTag'=> array(
            'className'     => 'PosTag',
            'foreignKey'    => 'post_id'
        )
    );
   
    public $belongsTo = array(
        'User' => array(
            'className'    => 'User',
            'foreignKey'   => 'user_id'
        )
    );
    
   public $validate = array(
        'name' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'message'  => 'Тільки букви та цифри'
            ),'notEmpty'=>array(
				'rule'    => 'notEmpty',
				'message' => 'Це поле не може бути порожнім'
			),
            
        ),
        'short_text' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'message'  => 'Тільки букви та цифри'
            ),
            'notEmpty'=>array(
				'rule'    => 'notEmpty',
				'message' => 'Це поле не може бути порожнім'
			),
         ),   
        'long_text' => array(
            'alphaNumeric' => array(
                'rule'     => 'alphaNumeric',
                'message'  => 'Тільки букви та цифри'
            ),'notEmpty'=>array(
				'rule'    => 'notEmpty',
				'message' => 'Це поле не може бути порожнім'
			),
         ),   
    );
}

?>
