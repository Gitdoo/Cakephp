<?php
/**
 * Users Controller
 * 
 * Клас, який описує Користувачів
 */
 App::uses('CakeEmail', 'Network/Email');
class UsersController extends AppController
{
    public $name = 'Users';
    public $components = array('Session',
								'Auth'=>array(
								'loginAction' => array('controller' => 'users', 'action' => 'login'),
								'loginRedirect' => array('controller' => 'posts', 'action' => 'index'),
								'logoutRedirect' => array('controller' => 'users', 'action' => 'login')
								)
							);
	public $helpers = array('Html','Form');
	
    public $uses=array('User','Group','GroupsPermission');
    
    /**
	* beforeFilter
	* Метод, який викликається перед кожною дією контроллера  
	* @access public
	*/
	
    public function beforeFilter(){
		
		$this->Auth->authorize = 'Controller';
		$this->Auth->allow('registration','forgot','recovery');

	}
	
    /**
     * index
     * 
     * Інфексний метод , який викликає метод login
     * 
     * @access public
     */
     
    public function index(){  
		 
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        $this->lists();
    }
    
    /**
     * registration
     * 
     * Метод , який здійснює реєстрацію користувача і робить незначну  валідацію
     * 
     * @return 
     * 
     * @access public
     */
     
    public function registration(){	
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		
		if (!empty($this->request->data['family']) && !empty($this->request->data['name']) && !empty($this->request->data['email']) && !empty($this->request->data['password'])) 
		{
			if ($this->request->data['password'] == $this->request->data['password2'])
			{
					if (!$this->User->findByEmail($this->request->data['email']))
					{
						
						$this->request->data['password'] = AuthComponent::password($this->request->data['password']);
						if(isset($this->request->data['moderator']))
						{
							$this->request->data['group_id']=2;
					    }
						else
						{
							$this->request->data['group_id']=3;
						}
						$this->User->create();
						$this->User->save($this->request->data);	
						
						$email = new CakeEmail();
						$email->from(array('guestbook@gbook.com' => 'Guestbook'));
						$email->to($this->request->data['email']);
						$email->subject('Реєстрація');
						$email->send("Ви успішно зареєструвалися!!! Ваш логін ".$this->request->data['email']." !!!");
						
						//mail($this->request->data['email'], "Реєстрація", "Ви успішно зареєструвалися ");
						$this->Session->SetFlash('Ви успішно зареєструвалися .');
						$this->redirect(array('action'=>'login'));
					}
					else 
					{
						$this->Session->SetFlash('Користувач з такою електронною адресою вже існує.');	
					}		
			}
			else $this->Session->SetFlash('Введені паролі не співпадають.');
		}
		else
		{ 
			$this->Session->SetFlash('Заповніть всі поля.');
		}
	}
	
	/**
     * recovery
     * 
     * Метод , який здійснює вiдновлення пароля
     * 
     * @return 
     * @param $hash string
     * @access public
     */
     
	public function recovery($hash=NULL){	
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		
		if (!$this->request->is('post'))
		{	$user=$this->User->findByHashode($hash);
			if ($user)
			{	$times=time();
				if ($times<=$user['User']['expires_time'])
				{	
					$this->set('user', $user);
				}
				else 
				{
					$this->Session->SetFlash('Ваше посилання не валідне.');
					$this->User->id = $user['User']['id'];
					$user['User']['hashode']=NULL;
					$user['User']['expires_time']=NULL;
					$this->User->save($user);
				}
			}
			else
			{
				$this->redirect(array('action'=>'index'));
			}
		}
		else
		{
			$user=$this->User->findByEmail($this->request->data['email']);
			$this->set('user', $user);
			if ($this->request->data['password'] === $this->request->data['password2'])
			{
				$user = $this->User->findByEmail($this->data['email']);
				$this->User->id = $user['User']['id'];
				$this->request->data['password'] = AuthComponent::password($this->request->data['password']);
				$this->request->data['hashode'] = NULL;
				$this->request->data['expires_time'] = NULL;
				$this->User->save($this->request->data);
				$this->Session->SetFlash('Пароль успішно змінено.');	
				$this->redirect(array('action'=>'login'));
			}
			else
				$this->Session->SetFlash('Введені паролі не співпадають.');			
		}
	}
	
	/**
     * login
     * 
     * Метод , який здійснює вхід користувача
     * 
     * @return 
     * @access public
     */
     
    public function login(){	
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		if ($this->request->is('post')) 
		{
		    if ($this->Auth->login($this->request->data))
				$this->redirect($this->Auth->redirect());
		    else 
				$this->Session->SetFlash('Пароль або email - невірні.');
		}
	}
	
	/**
     * logout
     * 
     * Метод , який здійснює вихід користувача
     * 
     * @return 
     * @access public
     */
     
	public function logout() {	
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$this->Session->delete('Permissions');
		$this->redirect($this->Auth->logout());
		
	}
	
	/**
     * forgot
     * 
     * Метод , який відсилає посилання на email, і встановлює час валідності посилання
     * 
     * @return 
     * @access public
     */
     
	public function forgot(){
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$this->set('status',$this->Auth->user());
		
		if($this->request->is('post'))
		{
			if ($user=$this->User->findByEmail($this->request->data['email']))
			{
				$hash = md5($this->request->data['email']);
				$times=time()+86400;
				$this->User->id = $user['User']['id'];
				$save=array('hashode'=>$hash,'expires_time'=>$times);
				$this->User->save($save);
				
				$email = new CakeEmail();
				$email->from(array('guestbook@gbook.com' => 'Guestbook'));
				$email->to($this->request->data['email']);
				$email->subject('Відновлення пароля');
				$email->send("<a href='users/newpass/'".$hash.">Відновлення паролю</a>");
				
				//mail($this->request->data['email'], "Відновлення пароля", "<a href='users/newpass/'".$hash.">Відновлення паролю</a>");
				$this->Session->SetFlash("Повідомлення на відновлення пароля відправлено  <a href='/cakephp/users/recovery/".$hash."'>Відновлення паролю</a>");
				$this->redirect(array('action'=>'login'));
			}
			else 
				$this->Session->SetFlash('Такого користувача не знайдено');
		}
	}
	
	/**
     * delete
     * 
     * Метод , який Видаляє користувача
     * 
     * @param $id int
     * @return
     * @access public
     */
     
	public function delete($id = null) {
		
        $this->User->id = $id;
        
        if (!$this->User->exists()) {
            throw new NotFoundException(__('Такого користувача не існує'));
        }
        if ($this->User->delete()) {
            $this->Session->setFlash(__('Користувач видалений'));
            $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('Користувач не може бути видалений'));
        $this->redirect(array('action' => 'index'));
    }
    
    /**
     * lists
     * 
     * Метод , який Виводить усіх користувачів і робить пагінацію
     * 
     * @return 
     * 
     * @access public
     */
     
    public function lists(){    	
		
        $users = $this->paginate();
        
    	if ($users)
        { 
    		$this->set('users', $users);
    		$this->set('error', '');
    		$this->set('status',$this->Auth->user());
        }
        else 
        {
            $this->set('users', $users);
            $this->set('error', 'Жодного запису не знайдено<br>');
            $this->set('status',$this->Auth->user());
        }
    }
	
	/**
     * view
     * 
     * Метод , який Виводить інформацію про окремого користувача
     * 
     * @return 
     * @param $id int
     * @access public
     */
     
    function view($id = null){
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        
        if (!$id) {
            throw new NotFoundException(__('Такого користувача не існує'));
        }
        $user=$this->User->findById($id);
        $posts=$this->User->Post->find('all', array('conditions'=>array('user_id'=>$id)));
        $this->set('user', $user);
        $this->set('posts', $posts);
    }
	
	
}
?>
