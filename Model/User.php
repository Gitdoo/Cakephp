<?php
App::uses('Model', 'AppModel');
/**
 * Post
 * 
 * Клас, який описує модель користувачів
 */
class User extends AppModel
{
	public $name = 'User';
	public $hasMany = array(
        'Post' => array(
            'className'     => 'Post',
            'foreignKey'    => 'user_id'
        )
       
    );
    public $belongsTo = array(
        'Group' => array(
            'className'    => 'Group',
            'foreignKey'   => 'group_id'
        )
    );
    
    public $validate = array(
        'family' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Поле не повиннебути порожнім'
            )
        ),
        'name' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Поле не повиннебути порожнім'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Поле не повиннебути порожнім'
            )
        ),
        'password2' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Поле не повиннебути порожнім'
            ),
        ),
        'email' => 'email'
        
    );
    
     
}

?>
