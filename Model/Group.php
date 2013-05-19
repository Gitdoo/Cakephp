<?php
/**
 * Group
 * 
 * Клас, який описує модель груп
 */
class Group extends AppModel {
    public $name = 'Group';
    public $hasMany = array(
        'User' => array(
            'className'     => 'User',
            'foreignKey'    => 'group_id'
        ) ,
        'GroupsPermission' => array(
						'className' => 'GroupsPermission',
                        'foreignKey' => 'group_id',                     
						),
    );
   
}
?>
