<?php
/**
 * Posts Controller
 * 
 * Клас, який описує пости
 */
class PostsController extends AppController
{
    public $name = 'Posts';
    public $components = array('Session','Auth');
	public $helpers = array('Html','Form','Paginator');
	public $paginate = array('limit' => 5 , 'order'=>array('created'=>'DESC'), 'separator'=>'***'); 
    public $uses=array('Post','Tag','User','PostsTag');
	/**
	* beforeFilter
	* Метод, який викликається перед кожною дією контроллера  
	* @access public
	*/
	
	function beforeFilter(){
		
		$this->Auth->authorize = 'Controller';
		$this->Auth->allow('index','search');
	}
	
	/**
     * isAuthorized
     * 
     * Викликається компонентою Auth для провірки доступу до методу
     * 
     * @return true ,якщо користувач має доступ /false ,якщо користувач не має доступу
     * @access public
     */
     
	public function isAuthorized($user) {
		
		if (in_array($this->action, array('edit', 'delete'))) {
			$postId = $this->request->params['pass'][0];

			$userId=$this->Post->User->find('first',array('conditions'=>array('email'=>$user['email'])));
			$userId=$userId['User']['id'];
       
			if ($this->Post->isOwnedBy($postId, $userId)) {
				return true;
			}
		}
		return parent::isAuthorized();
	}
	
	/**
     * index
     * 
     * Інфексний метод , який викликає метод lists
     * 
     * @access public
     */
     
    function index(){   
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        $this->lists();
    }
    
    /**
     * lists
     * 
     * Метод , який Виводить усі пости і робить пагінацію
     * 
     * @return 
     * 
     * @access public
     */
     
    function lists(){
		   	
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
    
    /**
     * view
     * 
     * Метод , який Виводить інформацію про окремий пост
     * 
     * @return 
     * @param $id int
     * @access public
     */
     
	function view($id = null){
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
        
        if (!$id) {
            throw new NotFoundException(__('Такого запиту не існує'));
        }
        $post=$this->Post->findById($id);
        $user=$this->Post->User->findById($post['Post']['user_id']);
        $post['Post']['email'] = $user['User']['email'];
        $tags_id =$this->Post->PostsTag->find('all', array('conditions'=>array('post_id'=>$id)));
        $tags=NULL;
        foreach ($tags_id as $tag)
        {
            $new_tag=$tag['PostsTag']['tag_id'];
            $new=$this->Tag->find('all', array('conditions'=>array('id'=>$new_tag)));
            $tags.=$new[0]['Tag']['tag'].",";
        } 
        
        $post['Post']['tags']=$tags;
        $this->set('post', $post);
	}
	
	/**
     * add
     * 
     * Метод , який додає новий пост пост
     * 
     * @return
     * @access public
     */
     
    public function add() {
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
		$user=$this->Post->User->findByEmail($this->Auth->user('email'));
	 	$this->set('user', $user);
	 	
        if ($this->request->is('post')) {
            $this->Post->create();
            if ($this->Post->save($this->request->data)) {
				$tags = $this->request->data['tags'];
				$tags=explode(',', $tags);
				foreach ($tags as $tag)
                {
					if (!$this->Post->PostsTag->Tag->findByTag($tag) && !empty($tag))
                        {   
							$this->Post->PostsTag->Tag->create();  
						    $this->Post->PostsTag->Tag->save(array('id'=>false,'tag'=>$tag));
					    }   
					    $tag=$this->Post->PostsTag->Tag->findByTag($tag);
						$this->Post->PostsTag->create(); 
						$this->Post->PostsTag->save(array('id'=>false,'tag_id'=>$tag['Tag']['id'],'post_id'=>$this->Post->id));
						
                }
                $this->Session->setFlash('Ви успішно додали запис.');
                $this->redirect(array('action' => 'index'));
            } 
            else 
            {
                $this->Session->setFlash('Ваш запис не додався');
            }
        }
    }
    
    /**
     * edit
     * 
     * Метод , який Редагує пост
     * 
     * @param $id int
     * @return
     * @access public
     */
     
    function edit($id){
		
		$this->layout = 'guestbook';
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
    
    /**
     * delete
     * 
     * Метод , який Видаляє пост
     * 
     * @param $id int
     * @return
     * @access public
     */
     
    function delete($id = null){
		
		$this->layout = 'guestbook';
		$this->set('status',$this->Auth->user());
    	
    	if ($this->Post->delete($id ))
        {
			$this->Post->PostsTag->deleteAll(array('PostsTag.post_id' => $id));
            $this->Session->setFlash('Ваш запис успішно видалений !!!');
            $this->redirect(array('action' => 'index'));
        }
        else 
        {
            $this->Session->setFlash('Ваш запис не видалений, спробуйте знову.');
            $this->redirect(array('action' => 'index'));
		}
    }
    
    /**
     * search
     * 
     * Метод , який здійснює пошук посту
     * 
     * @return
     * @access public
     */
     
	function search(){	
		
		$this->layout = 'guestbook';
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
