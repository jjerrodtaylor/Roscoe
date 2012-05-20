<?php
/**
 * Messages Controller
 *
 * PHP version 5
 *
 * @ Controller
 */
class MessagesController extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var	$name	=	'Messages';
	var $components = array('Upload');
	var $helpers	=	array('Html', 'Recaptcha');
	
	/*
	* beforeFilter
	* @return void
	*/
	function beforeFilter(){
		parent::beforeFilter();		 
		// CSRF Protection
        if (in_array($this->params['action'], array('admin_process', 'admin_add', 'admin_edit','admin_delete','inbox','delete','send_message','msgprocess','msgprocess_outbox','msgprocess_parmanently_delete'))) {
            $this->Security->validatePost = false;						
        }
		 //$this->Wizard->steps = array('profile', 'category', 'list_items', 'choose_question', 'about_you', 'upload_pictures');	
		
		$this->set('User', parent::leftnav());		
	}
	
	/*
	* List all user messages 
	*/	
	function admin_index($id = null){
		//Configure::write('debug',);
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('AdminSearch');
		}
		$filters = array();
		if(!empty($this->data)){
			//pr($this->data);die;
			$this->Session->delete('AdminSearch');
			App::import('Sanitize');			
			$filters = array();
			if(isset($this->data['Message']['sender']) && $this->data['Message']['sender']!=''){
				$sender_id = Sanitize::escape($this->data['Message']['sender']);
				$this->Session->write('AdminSearch.sender_id', $sender_id);	
			}				
			if(isset($this->data['Message']['is_viewed']) && $this->data['Message']['is_viewed']!=''){
				$status = Sanitize::escape($this->data['Message']['is_viewed']);
				$this->Session->write('AdminSearch.is_viewed', $status);	
			}			
		}
		if($this->Session->check('AdminSearch')){
			$keywords  = $this->Session->read('AdminSearch');		
			foreach($keywords as $key=>$values){
				if($key == 'is_viewed'){
					$filters[] = array('Message.'.$key =>$values);
				}
				else{
				 $filters[] = array('Message.'.$key.' LIKE'=>"%".$values."%");
				} 
			}			
		}
		
		$filters[] = array('Message.receiver_id'=>$id);
	
		$this->paginate['Message'] = array(
									'limit'=>Configure::read('App.AdminPageLimit'), 
									'order'=>array('Message.subject'=>'ASC'),
									'conditions'=>$filters
									);
		
		$data = $this->paginate('Message'); 
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('Member Inbox', true));		
	}
	
	//FUNCTION FOR EDIT THE MESSAAGE
	
	function admin_edit($id = null){
	$this->set("title_for_layout", __('Edit Message', true));	
		
		
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid Message');
			$this->redirect(array('action' => 'index'));
		}
		
		if(!empty($this->data)) {
			$mid = $this->data['Message']['receiver_id'];
		    // validate & save data
			 $this->Message->set($this->data);
			 $this->Message->setValidation('admin');
			 if ($this->Message->validates()) {			 	
				if ($this->Message->save($this->data)) {								
					$this->Session->setFlash(__('The Message has been updated', true), 'admin_flash_good');
					$this->redirect(array('controller'=>'messages', 'action' => 'index/'.$mid.''));
				} 
				else {
					$this->Session->setFlash(__('Please correct the errors listed below.', true), 'admin_flash_bad');
				}
			} 
			else {
				$this->Session->setFlash(__('The Role could not be saved. Please, try again.', true), 'admin_flash_bad');
			}
		}
        else{
			 
			 $this->data = $this->Message->read(null, $id);
		  
		    }
	}
	
	//FUNCTION FOR DELETE ANY MESSAGE
	
	function admin_delete($id = null){
		if (!$id) {
            $this->Session->setFlash(__('Invalid id for Message', true), 'admin_flash_good');
            $this->redirect(array('action' => 'message'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }
		$this->data = $this->Message->read(null, $id);
		$mid = $this->data['Message']['receiver_id'];
        if ($this->Message->delete($id)) {
            $this->Session->setFlash(__('Message deleted', true), 'admin_flash_good');
            $this->redirect(array('controller'=>'messages','action' => 'index/'.$mid.''));
        }	
	}	
	
	
	//FUNCTION FOR VIEW THE MESSAGE
	
	function admin_view($id = null){
		$this->set("title_for_layout", __('Read Message', true));		
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid user');
			$this->redirect(array('action' => 'index'));
		}
		if(!empty($this->data)) {
			$mid = $this->data['Message']['receiver_id'];
			if (!isset($this->params['data']['_Token']['key']) || ($this->params['data']['_Token']['key'] != $this->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			if ($this->Message->save($this->data)) {						
					$this->Session->setFlash(__('The Message is read successfully', true), 'admin_flash_good');
					$this->redirect(array('controller'=>'messages','action' => 'index/'.$mid.''));
				}  
		}
        else{
		//	$users = $this->Message->User->getUserlist();	
			//$this->set(compact('users'));
			$this->data = $this->Message->read(null, $id);
      }
	}
	
	//FUNCTION FOR ADMIN PROCESS
	
	function admin_process(){
		if(!empty($this->data)){
			//pr($this->data);die;
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['Message']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }			
			App::import('Sanitize');
			$action = Sanitize::escape($this->data['Message']['pageAction']);	  
			foreach ($this->data['Message'] AS $value) {	      
				if ($value != 0) {
						$ids[] = $value;				
				}
			}
		
			if (count($this->data) == 0 || $this->data['Message'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect($this->referer());
			}
			
			if($action == "delete"){
				$this->Message->deleteAll(array('Message.id'=>$ids));
				$this->Session->setFlash('Messages have been deleted successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}		
		}
		else{
			$this->redirect(array('controller'=>'messages', 'action'=>'index'));
		}
	}
	
	
	function inbox ($id=null){
	
		
		
		$this->set("title_for_layout", " Inbox Messages");
		$this->layout = "default";
		$type =1;
		if($this->Session->check('Auth.User.id')){
			$this->Message->bindModel(array(
					'belongsTo' => array(
						'User' => array(
						'foreignKey' => 'sender_id',
						'fields' => array('id', 'username')
						)
					)
				),false);
				
			if($this->RequestHandler->isAjax()){ 
				if(isset($this->params['form']['UpperPerPage'])){
					if(isset($this->params['form']['UpperPerPage'])){      			
						$limit = $this->params['form']['UpperPerPage'];
						$this->Session->write('Messageslisting.PerPage', $limit);
					}
				}			  
				if($this->Session->check('Messageslisting.PerPage')){
					$limit = $this->Session->read('Messageslisting.PerPage');
				}			  
				else{
					$limit =  Configure::read('App.PageLimit');
				}	
				  
			}
			else{		    
				 	$limit =  Configure::read('App.PageLimit');
					$this->Session->delete('Messageslisting');		   
			}	
				
			$this->paginate;
		}
	}
}
?>