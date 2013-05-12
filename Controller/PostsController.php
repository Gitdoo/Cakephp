<?php

class PostsController extends AppController
{
    public $name = 'Posts';
    public $components = array('Session','Auth');
	public $helpers = array('Html','Form','Paginator');
	public $paginate = array('limit' => 3 , 'order'=>array('created'=>'DESC'), 'separator'=>'***'); 
    public $uses=array('Post','Tag','User','PostTag');
	
    
    function index()
    {   
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        $this->lists();
    }
    
    //Виводить усі пости і робить пагінацію
     function lists()
    {    	
        $posts = $this->paginate();
        
    	if ($posts)
        { 
			
    		$this->set('posts', $posts);
    		$this->set('error', '');
    		$this->set('status',$this->Auth->user());
        }
        else 
        {
            $this->set('posts', $posts);
            $this->set('error', 'Жодного запису не знайдено<br>');
            $this->set('status',$this->Auth->user());
        }
    }
    //Виводить інформацію про окремий пост
    function view($id = null)
    {
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        
        if (!$id) {
            throw new NotFoundException(__('Invalid post'));
        }
        $post=$this->Post->findById($id);
        $user=$this->User->findById($post['Post']['user_id']);
        $post['Post']['email'] = $user['User']['email'];
        $this->set('post', $post);
        
        
    }
    //Додає пост
    public function add() {
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$user=$this->User->findByEmail($this->Auth->user('email'));
	 	$this->set('user', $user);
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
                $this->Session->setFlash('Ви успішно додали запис.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Ваш запис не додався');
            }
        }
    }
    //Редагує пост
    function edit($id)
    {	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
       	$this->set('post', $this->Post->findById($id));
       	
        if ($this->request->is('post'))
        {
			$this->Post->id=$id;
            if ($this->Post->save($this->request->data))
            {
				$this->Session->setFlash('Редагування пройшло успішно!!!');
                $this->redirect(array('action' => 'index'));
            }
            else
        	{
                $this->data = $this->Post->findById($id);
                $this->Session->setFlash('Ви не заповнили всі поля');
        	}
        }
    }
    //Видаляє пост
    function delete($id = null)
    {	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
    	if ($this->Post->delete($id, NULL))
        {
            $this->Session->setFlash('Ваш запис успішно видалений !!!');
            $this->redirect(array('action' => 'index'));
        }
        else 
            $this->Session->setFlash('фывыфв');
            $this->redirect(array('action' => 'index'));
    }
	//Шукає пост 
	function search()
    {	$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        $search = $this->data['search'];
        $condition = array('OR'=>array("`Post`.`created` LIKE '%$search%'","MATCH `Post`.`name` AGAINST('$search')", "MATCH `Post`.`short_text` AGAINST('$search')"));            
        if ($data = $this->Post->find('all', array('order'=>array('`Post`.created'=>'DESC'), 'conditions'=>$condition)))
        {
            $this->set('posts', $data);
            $this->set('error', '');
        }
        else 
        {           
            $this->set('posts', $data);
            $this->set('error', 'Нічого не знайдено!!<br>');
        }
    }
}
?>
