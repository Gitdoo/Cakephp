<?php

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
	
    public $uses=array('User');
    
    
    function beforeFilter()
	{
		$this->Auth->allow('registration','forgot','recovery');
	}
    
    //індексний метод, викликає метод login
    public function index()
    {	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$this->login();
	}
	//реєстрація користувача і незначна валідація
    public function registration()
	{	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		
		if (!empty($this->request->data['family']) && !empty($this->request->data['name']) && !empty($this->request->data['email']) && !empty($this->request->data['password'])) 
		{
			if ($this->request->data['password'] == $this->request->data['password2'])
			{
					if (!$this->User->findByEmail($this->request->data['email']))
					{
						
						$this->request->data['password'] = AuthComponent::password($this->request->data['password']);
						$this->User->create();
						$this->User->save($this->request->data);	
						
						mail($this->request->data['email'], "Реєстрація", "Ви успішно зареєструвалися ");
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
	//вiдновлення пароля
	public function recovery($hash=NULL)
	{	
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
				$this->Session->SetFlash('Пароль успішно змінено.'.$user['User']['id']);	
				$this->redirect(array('action'=>'login'));
			}
			else
				$this->Session->SetFlash('Введені паролі не співпадають.');			
		}
	}

    //вхід 
    public function login()
	{	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		if ($this->request->is('post')) 
		{
		    if ($this->Auth->login($this->request->data))
				$this->redirect($this->Auth->redirect());
		    else $this->Session->SetFlash('Пароль або email - невірні.');
		}
	 
	}
	//вихід
	public function logout() 
	{	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$this->redirect($this->Auth->logout());
	}
	
	
	//метод який відсилає посилання на email
	public function forgot()
	{
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
				mail($this->request->data['email'], "Відновлення пароля", "<a href='users/newpass/'".$hash.">Відновлення паролю</a>");
				$this->Session->SetFlash("Повідомлення на відновлення пароля відправлено  <a href='/cakephp/users/recovery/".$hash."'>Відновлення паролю</a>");
				$this->redirect(array('action'=>'login'));
			}
			else 
				$this->Session->SetFlash('Такого користувача не знайдено');
		}
	}
    
	
	
	
}
?>
