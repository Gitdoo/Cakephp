<?php
/**
 * Permission
 * 
 * Клас, який описує модель доступів
 */
class Permission extends AppModel {
    public $name = 'Permission';
    public $hasMany = array( 
            'GroupsPermission' => array(
						'className' => 'GroupsPermission',
                        'foreignKey' => 'permission_id',
            )
    );
}
?>
