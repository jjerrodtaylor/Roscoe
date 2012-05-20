<?php
/**
 * Fronts Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
  class StaticPagesController extends AppController{
     /**
     * Controller name
     *
     * @var string
     * @access public
     */
	 var $name = 'StaticPages';	
     /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
     var $uses =array('StaticPage');
		 
	 function beforeFilter(){
	 parent::beforeFilter();
	 $this->Auth->allow('tell_a_friend','page','contact_us');
	 	  	  	  
	 }
	 
	 function admin_index(){		
	 if(!isset($this->params['named']['page'])){
	 	$this->Session->delete('StaticPageSearch');
	 }
  	 $filters = array(); 
	 if( !empty($this->data)){			          
			$this->Session->delete('StaticPageSearch');
			$keyword = $this->data['StaticPage']['title'];
			if(!empty($this->data['StaticPage']['title'])){
			 App::import('Sanitize');
			 $keyword = Sanitize::paranoid($this->data['StaticPage']['title']);
			 $this->Session->write('StaticPageSearch', $keyword);				
			}
			
        }
	   if($this->Session->check('StaticPageSearch')){
		 	$filters[] = array('StaticPage.title LIKE'=>"%".$this->Session->read('StaticPageSearch')."%");					
		 }
        
        $this->paginate['StaticPage'] = array(
	                                  'limit'=>Configure::read('App.AdminPageLimit'), 
									  'order'=>array('StaticPage.id'=>'DESC'),
			                          'conditions'=>$filters
										);
	  $result = $this->paginate('StaticPage');        
	  $this->set('data', $result);	 
	  $this->pageTitle = __('Static Page', true);	
	}
	 
	 function admin_add(){	
	  $this->pageTitle = __('Add Static Page', true);	
	   if(!empty($this->data)){
	     $this->StaticPage->setValidation('admin');
         $this->StaticPage->set($this->data);
		 if($this->StaticPage->validates()){
		   $this->StaticPage->create();
		   $this->data['StaticPage']['created'] = date('Y-m-d H:i:s');
		   $this->StaticPage->save($this->data);
		   $this->Session->setFlash('Page has been added successfully.', 'admin_flash_good');
		   $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
		 }		
		 else {
				$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
			} 
	   }
	   
	 }
	 
	 function admin_edit($id = null){
	 	$this->pageTitle = __('Edit Static Page', true);
	 	if($id == null){
	 		$this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
	 	}
	 	if(!empty($this->data)){
	 		$this->StaticPage->setValidation('admin');
	 		$this->StaticPage->set($this->data);
	 		if($this->StaticPage->validates()){	 		
		 		$this->data['StaticPage']['modified'] = date('Y-m-d H:i:s');
		 		$this->StaticPage->save($this->data);
		 		$this->Session->setFlash('Page has been updated successfully.', 'admin_flash_good');
			    $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
	 		}
	 		else{
	 			$this->Session->setFlash('Please correct the errors listed below', 'admin_flash_bad');
	 		}
	 	}
	 	else{
	 		$this->data = $this->StaticPage->read(null, $id);
	 	}	 	
	 }
	 
	 function admin_delete($id = null){
	   if (!$id) {
            $this->Session->setFlash(__('Invalid id for Category', true));
            $this->redirect(array('action' => 'index'));
        }
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
            $this->redirect(array('controller'=>'static_pages','action' => 'index'));
        }
        if ($this->StaticPage->delete($id)) {           
            $this->Session->setFlash('Static page has been deleted successfully.', 'admin_flash_good');
            $this->redirect(array('controller'=>'static_pages','action' => 'index'));
        }
	 	
	 }
	 
	 function admin_process(){	 
	   
	   if(!empty($this->data)){ 
	    App::import('Sanitize');
	    $action = Sanitize::escape($_POST['pageAction']);	  
        foreach ($this->data['StaticPage'] AS $value) {	      
            if ($value != 0) {
                $ids[] = $value;				
            }
        }
		
		
	   if (count($this->data) == 0 || $this->data['StaticPage'] == null) {
            $this->Session->setFlash('No items selected.', 'admin_flash_bad');
            $this->redirect(array('controller' => 'static_pages', 'action' => 'index'));
        }
        if($action == "delete"){
        	$this->StaticPage->deleteAll(array('StaticPage.id'=>$ids));
        	$this->Session->setFlash('Pages have been deleted successfully', 'admin_flash_good');
        	 $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
        }
		if($action == "activate"){
        	$this->StaticPage->updateAll(array('StaticPage.status'=>Configure::read('App.Status.active')),array('StaticPage.id'=>$ids));
        	$this->Session->setFlash('Pages have been activated successfully', 'admin_flash_good');
        	 $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
        }
		if($action == "deactivate"){
        	$this->StaticPage->updateAll(array('StaticPage.status'=>Configure::read('App.Status.inactive')),array('StaticPage.id'=>$ids));
        	$this->Session->setFlash('Pages have been deactivated successfully', 'admin_flash_good');
        	 $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
        }
	  }
	  else{
	       $this->redirect(array('controller'=>'static_pages', 'action'=>'index'));
	  }
	 }
	 
	 

	 //-------------------	Start: Front end -----------------------------------
	
	function get_static_page_list()
	{
		$static_page_list=array();
		$static_page_list = $this->StaticPage->find('all', array('conditions' => array('StaticPage.status' => 1)));
		return $static_page_list;	
		//pr($static_page_list);die;
	}	
  	
	function page($pageN=null) 
	{	
		 $page_detail = $this->StaticPage->find('first', array('conditions' => array('StaticPage.slug' => $pageN,'StaticPage.status' => '1')));
		 if(empty($page_detail)){
			$this->redirect(array('controller'=>'fronts','action'=>'index'));
		 }else{
			$this->Set("page_detail", $page_detail);
		 }
		 	
		 
	}
	/* =======================Contact us action ============================ */
	function contact_us(){
		
		$this->loadModel('Contact');
		$this->set('title_for_layout','Contact Us');
		if(!empty($this->data)){
			$this->data['Contact'] = $this->General->myclean($this->data['Contact']);
			//prd($this->data['Contact']);
			$this->Contact->setValidation('front');
			$this->Contact->set($this->data);
			if($this->Contact->validates()){
				$this->Email->to = Configure::read('App.AdminMail');
				$this->Email->from = $this->data['Contact']['email'];
				$this->Email->subject = $this->data['Contact']['subject'];
				$this->Email->sendAs = 'html';
				$this->Email->template = 'contact';
				
				if($this->Email->send()){
					$this->Session->setFlash('Thanks! Message sent successfully.','flash_good');
					unset($this->data);
					$this->redirect(array('action'=>'contact_us'));
				}else{
					$this->Session->setFlash('Sorry! There was a problem sending message.Please again try.','flash_bad');
				}
				//pr($this->Contact);die;
			}else{
				$this->Session->setFlash('Please correct the errors listed below','flash_bad');
			}
		}elseif($this->Auth->user('id')){			
			$this->data = $this->Contact->read(null,$this->Auth->user('id'));			
			$this->data['Contact']['name'] = ucwords($this->data['ContactReference']['first_name']).' '.ucwords($this->data['ContactReference']['last_name']);
		}
		
	}
	/* =======================End of Contact us action ============================ */


	/* ========================Tell a friend action ======================== */

	function tell_a_friend(){
		
		$this->loadModel('TellFriend');
		$this->set('title_for_layout','Tell A Friend');
		//echo 'I am here';die;
		if(!empty($this->data)){
			$this->data['TellFriend'] = $this->General->myclean($this->data['TellFriend']);
			$this->TellFriend->setValidation('front');
			$this->TellFriend->set($this->data);
			if($this->TellFriend->validates()){
				//prd($this->data);
				$this->Email->to = $this->data['TellFriend']['to'];
				if(!empty($this->data['TellFriend']['bcc'])){
					$this->Email->bcc = array($this->data['TellFriend']['bcc']);				
				}
				if(!empty($this->data['TellFriend']['cc'])){
					$this->Email->cc = array($this->data['TellFriend']['cc']);				
				}
				
				
				$this->Email->from = $this->data['TellFriend']['from'];
				$this->Email->subject = $this->data['TellFriend']['subject'];
				$this->Email->sendAs = 'html';
				$this->Email->template = 'tell_a_friend';
				if($this->Email->send()){
					$this->Session->setFlash('Thanks! Message sent successfully.','flash_good');
					unset($this->data);
					$this->redirect(array('action'=>'tell_a_friend'));
				}else{
					$this->Session->setFlash('Sorry! There was a problem sending message.Please again try.','flash_bad');
					$this->redirect(array('action'=>'tell_a_friend'));
				}
				//pr($this->Contact);die;
			}else{
				$this->Session->setFlash('Please correct the errors listed below','flash_bad');
			}
		}elseif($this->Auth->user('id')){			
			$data = $this->TellFriend->read(array('TellFriendReference.first_name','TellFriendReference.last_name'),$this->Auth->user('id'));			
			$this->data['TellFriend']['name'] = ucwords($data['TellFriendReference']['first_name']).' '.ucwords($data['TellFriendReference']['last_name']);
			$this->data['TellFriend']['from'] = $this->Auth->user('email');
		
		}
	}
  }
?>