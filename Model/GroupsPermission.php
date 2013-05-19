<?php
/**
 * GroupsPermission
 * 
 * Клас, який описує модель звязку груп та доступів
 */
class GroupsPermission extends AppModel {
    public $name = 'GroupsPermission';
    public $belongsTo = array('Group'=> array(
            'className'    => 'Group',
            'foreignKey'   => 'group_id'
        ),
        'Permission'=> array(
            'className'    => 'Permission',
            'foreignKey'   => 'permission_id'
        )
   );
}
?>
