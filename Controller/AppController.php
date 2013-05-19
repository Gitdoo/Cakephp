<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Session','Auth');
	public $uses=array('Post','Tag','User','PostsTag','Group','Permission');
	
	
	/**
	* beforeFilter
	* Метод, який викликається перед кожною дією контроллера  
	* @access public
	*/
	public function beforeFilter() {
		$this->Auth->fields = array('username'=>'email','password'=>'password');
        $this->Auth->authorize = 'Controller';
	}
     /**
     * isAuthorized
     * 
     * Викликається компонентою Auth для провірки доступу до методу
     * 
     * @return true ,якщо користувач має доступ /false ,якщо користувач не має доступу
     * @access public
     */
	function isAuthorized(){
		return $this->__permitted($this->name,$this->action);
		
	}
    /**
     * __permitted
     * 
     * Метод , який здійснює провірку доступу користувача до методів,провірка здійснюється у форматі $Controller:$action
     * 
     * @return true ,якщо користувач має доступ /false ,якщо користувач не має доступу
     * @param $controllerName Object
     * @param $actionName Object
     * @access public
     */
	function __permitted($controllerName,$actionName){
		if(!$this->Session->check('Permissions')){
            $permissions = array();
            $permissions[]='Users:logout';
            $thisUser= $this->User->find('first', array('conditions'=>array('User.email'=>$this->Auth->user('email'))));
			$thisGroup = $thisUser['Group'];
			$thisPermissionsId = $this->User->Group->GroupsPermission->find('all', array('conditions'=>array('GroupsPermission.group_id'=>$thisGroup['id'])));
			
			foreach($thisPermissionsId as $thisPermissionId){
				$permissions[]=$thisPermissionId['Permission']['permission'];
			}

            $this->Session->write('Permissions',$permissions);
        }else{
            
            $permissions = $this->Session->read('Permissions');
        }
        
        foreach($permissions as $permission){
            if($permission == '*'){
                return true;
            }
            if($permission == $controllerName.':*'){
               return true;
            }
            if($permission == $controllerName.':'.$actionName){
               return true;
            }
        }
        return false;
    }
    
    
    
}

