<?php
	/**
	* Users Controller
	*
	* PHP version 5
	* Project start date 29 Mar 2012
	* Developed by :Sandeep singh 
	* Company info:Octalsolution 
	* @Users Controller
	*/
	App::import('Sanitize');
	class UsersController extends AppController{
		/**
		* Controller name
		*
		* @var string
		* @access public
		*/
		var $name = 'Users';
		/**
		* Models used by the Controller
		*
		* @var array
		* @access public
		*/	 
		var $uses =array('User','UserReference');
		var $helpers = array('General','Form','Ajax','javascript','Paginator');
		var $components = array("Session", "Email","Auth","RequestHandler","Wizard");

		function beforeFilter(){
			parent::beforeFilter();	 
			$this->Auth->allow('register');
		}
		function admin_login(){
			$this->set('title_for_layout','Admin User Login');
			$this->layout = 'admin_login';
			if($this->Auth->user()){
				if($this->Auth->user('id') == '1') {
					$this->Session->write('Admin.email', $this->data['User']['email']);
					$this->Session->write('Admin.password', $_POST['data']['User']['password']);                        
					$this->redirect($this->Auth->redirect());
				}
			} 	  
		}	 
		function admin_dashboard(){
			$this->set('title_for_layout','Dashboard');  
		}
		function admin_logout(){	   
			$this->Session->setFlash(__('Log out successful.', true));	
			$this->redirect($this->Auth->logout());	
		}
		function admin_index(){
			if(!isset($this->params['named']['page'])){
				$this->Session->delete('UserSearch');
			}
			$this->User->bindModel(array('hasOne'=>array('UserReference')),false) ;
			$filters = array('User.role_id=1'); 
			if(!empty($this->data)){
				$this->Session->delete('UserSearch');
				if(!empty($this->data['UserReference']['first_name'])){
					$keyword = Sanitize::escape($this->data['UserReference']['first_name']);
					$this->Session->write('UserSearch', $keyword);				
				}				
			}

			if($this->Session->check('UserSearch')){		
				$filters[] = array('UserReference.first_name LIKE'=>"%".$this->Session->read('UserSearch')."%");					
			}
			/*Paginate method is used to find all listing of countries */
			$this->paginate['User'] = array(
					'limit'=>Configure::read('App.AdminPageLimit'), 
					'order'=>array('User.username'=>'ASC'),
					'conditions'=>$filters
				);

			$data = $this->paginate('User'); 
			//prd($data);
			$this->set('data',$data);	 
			$this->set('title_for_layout',  __('User', true));	
		}
		function admin_add() {
			$this->set('title_for_layout','Add Admin Users');  
			if(!empty($this->data)) {
				$this->User->set($this->data);
				$this->User->setValidation('admin');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('admin');
				$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
				if($this->User->saveAll($this->data,array('validate'=>'first'))) {
					$this->Session->setFlash('The Admin has been saved', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}else{
				unset($this->data['User']['username']);
			}
		} 
		function admin_edit($id = null) {	

			$this->set('title_for_layout',"Edit Admin Users");	
			if(!$id && empty($this->data)) {		
				$this->Session->setFlash('Invalid user');
				$this->redirect(array('action' => 'index'));
			}		
			if(!empty($this->data)) {
				$this->User->data['User']['role_id'] = 1;
				$this->User->set($this->data);
				$this->User->setValidation('admin');
				
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('admin');

				if($this->User->validates() && $this->UserReference->validates() ) {	
					if ($this->User->saveAll($this->data)) {

						$this->Session->setFlash('The User has been saved', 'admin_flash_good');
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
					}
				} else {
					$this->Session->setFlash('The Admin could not be saved. Please, try again.', 'admin_flash_bad');
				}
			}else{
				$this->data = $this->User->read(null, $id);
			}   		
		}

		function admin_delete($id = null) {
			if(!$id) {
				$this->Session->setFlash('Invalid id for Admin');
				$this->redirect(array('action'=>'index'));
			}
			$admin = $this->User->read(null, $id);
			if(empty($admin)) {
				$this->Session->setFlash('Invalid User', 'admin_flash_bad');
				$this->redirect(array('action' => 'index'));
			}
			if($this->User->delete($id)) {	 
				$this->Session->setFlash('User has been deleted successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));		
			}
			$this->Session->setFlash('User has not deleted', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}

		function message_delete($flag = null ,$id=null) {
			$this->loadModel('MessageCenter');
			if(!$id) {
				$this->Session->setFlash('Invalid id for users');
				$this->redirect(array('action'=>'message_center'));
			}
			$front = $this->MessageCenter->read(null, $id);
			if(empty($front)) {
				$this->Session->setFlash('Invalid Message', 'flash_bad');
				$this->redirect(array('action' => 'message_center'));
			}
			if($flag=="inbox"){
				$data = array(
						'MessageCenter' => array(
								'id'          =>    $id,
								'receiver_delete'   =>    1
							)
					);
				$this->MessageCenter->save($data, false, array('receiver_delete') );
			}
			if($flag=="outbox")
			{
				$data = array(
					'MessageCenter' => array(
							'id'          =>    $id,
							'sender_delete'   =>    1
						)
					);
				$this->MessageCenter->save($data, false, array('sender_delete') );
			}
			$this->Session->setFlash('User has been deleted successfully', 'flash_bad');
			$this->redirect(array('action' => 'message_center'));
		}
		function admin_process(){		   

			if(!empty($this->data)){
				App::import('Sanitize');
				$action = Sanitize::escape($this->data['User']['pageAction']);	  
				foreach ($this->data['User'] AS $value) {	      
					if ($value != 0) {
						$ids[] = $value;				
					}
				}

				if (count($this->data) == 0 || $this->data['User'] == null) {
					$this->Session->setFlash('No items selected.', 'admin_flash_bad');
					$this->redirect(array('controller' => 'Users', 'action' => 'index'));
				}
				if($action == "delete"){
					$this->User->deleteAll(array('User.id'=>$ids));        	
					$this->Session->setFlash('Users have been deleted successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Users', 'action'=>'index'));
				}
				if($action == "activate"){
					$this->User->updateAll(array('User.status'=>Configure::read('App.Status.active')),array('User.id'=>$ids));
					$this->Session->setFlash('Users have been activated successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Users', 'action'=>'index'));
				}
				if($action == "deactivate"){
					$this->User->updateAll(array('User.status'=>Configure::read('App.Status.inactive')),array('User.id'=>$ids));
					$this->Session->setFlash('Users have been deactivated successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Users', 'action'=>'index'));
				}
			}else{
				$this->redirect(array('controller'=>'Users', 'action'=>'index'));
			}
		}

		function admin_changepassword($id = null){
			$this->pageTitle = __('Change Password', true);     
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
			if(!empty($this->data)){
				$this->User->setValidation('change_password');
				$this->User->set($this->data);
				if($this->User->validates()){
					$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
					$this->User->updateAll(array('password'=>"'".$this->data['User']['password']."'"), array('User.id'=>$id));
					$this->Session->setFlash('Password has been changed successfully', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}
			}else{
				$this->data = $this->User->read(null, $id);
			}          

		}

		function admin_viewuser($id=null){
			$this->set('title_for_layout','View User');
			if($id){
				$user_information =$this->User->find('all', array('conditions' => array('User.id' =>$this->Auth->user('id'))));
				$this->set('data', $user_information);
			} 
		}
		/* **************front page processing******** */

	}
	?>