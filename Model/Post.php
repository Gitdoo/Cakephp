<?php
/**
 * Post
 * 
 * Клас, який описує модель постів
 */
App::uses('Model', 'AppModel');
class Post extends AppModel
{
   public $name = 'Post';
   public $hasMany = array(
		'PostsTag'=> array(
            'className'     => 'PostsTag',
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
    /**
     * isOwnedBy
     * 
     * Метод , який здійснює провірку того чи user_id поста =id користувача
     * 
     * @return true ,якщо user_id поста =id користувача/ false в ыншому випадку 
     * @param $post int
     * @param $user int
     * @access public
     */
    public function isOwnedBy($post, $user) {
		return $this->field('id', array('id' => $post, 'user_id' => $user)) === $post;
	}
}

?>
