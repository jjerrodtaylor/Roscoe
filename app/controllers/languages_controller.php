<?php
/**
 * Users Controller
 *
 * PHP version 5
 * Project start date 19 july 2011
 * Developed by :kanhaiya Dhaked 
 * Company info:Octalsolution 
 * @category Controller
 */
 class LanguagesController extends AppController{
     /**
     * Controller name
     *
     * @var string
     * @access public
     */
	 var $name = 'Languages';
     /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
     var $uses =array('Language');
     var $helpers = array('General','Form');
     var $components = array("Session", "Email","Auth","RequestHandler");
 	 function beforeFilter(){
	 	parent::beforeFilter();	 
	 	//$this->Auth->allow();
    }
	/*******************************************************
	 * admin  users  listing Display  
	 * modified date :18-08-11
	 * Midified By Kanhaiya Dhaked  
	 * ****************************************************/
	function admin_index(){		
	
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('StaticPageSearch');
		}
		$filters = array(); 
		
		if(!empty($this->data)){			          
			$this->Session->delete('StaticPageSearch');
			$keyword = $this->data['Language']['name'];
			if(!empty($this->data['Language']['name'])){
			 App::import('Sanitize');
			 $keyword = Sanitize::paranoid($this->data['Language']['name']);
			 $this->Session->write('StaticPageSearch', $keyword);				
			}
			
        }
	   if($this->Session->check('StaticPageSearch')){
		 	$filters[] = array('Language.name LIKE'=>"%".$this->Session->read('StaticPageSearch')."%");					
		 }
        
        $this->paginate['Language'] = array(
	                                  'limit'=>Configure::read('App.AdminPageLimit'), 
									  'order'=>array('Language.id'=>'DESC'),
			                          'conditions'=>$filters
										);
	  $result = $this->paginate('Language');        
	  $this->set('data', $result);	 
	  $this->pageTitle = __('Static Page', true);	
	}
	/*******************************************************
	 * add admin  users 
	 * modified date :20-07-11
	 * Midified By Kanhaiya Dhaked  
	 * ****************************************************/
	function admin_add() {
		$this->set('title_for_layout','Add New  Language');  
		if(!empty($this->data)) {
			$this->Language->set($this->data);
			$this->Language->setValidation('lang');
			if($this->Language->validates()) {
				if($this->Language->saveAll($this->data,array('validate'=>'first'))) {
					$this->Session->setFlash('The Admin has been saved', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
						$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}else{
					$this->Session->setFlash('The Language could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}
	} 
	/*******************************************************
	 * add admin  users  Edit /update
	 * modified date :20-07-11
	 * Midified By Kanhaiya Dhaked  
	 * ****************************************************/
	function admin_edit($id = null){
	 	$this->pageTitle = __('Edit Language', true);
	 	if($id == null){
	 		$this->redirect(array('controller'=>'languages', 'action'=>'index'));
	 	}
	 	if(!empty($this->data)){
	 		$this->Language->setValidation('lang');
	 		$this->Language->set($this->data);
	 		if($this->Language->validates()){	 		
		 		$this->Language->save($this->data);
		 		$this->Session->setFlash('Page has been updated successfully.', 'admin_flash_good');
			    $this->redirect(array('controller'=>'languages', 'action'=>'index'));
	 		}
	 		else{
	 			$this->Session->setFlash('Please correct the errors listed below', 'admin_flash_bad');
	 		}
	 	}
	 	else{
	 		$this->data = $this->Language->read(null, $id);
	 	}	 	
	 }
	/*******************************************************
	 * add admin  users  Delete By Super admin
	 * modified date :20-07-11
	 * Midified By Kanhaiya Dhaked  
	 * ****************************************************/
	function admin_delete($id = null) {
		if(!$id) {
			$this->Session->setFlash('Invalid id for Admin');
			$this->redirect(array('action'=>'index'));
		}
		$admin = $this->Language->read(null, $id);
		if(empty($admin)) {
			$this->Session->setFlash('Invalid Language', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		
		if($this->Language->delete($id)) {	 
			$this->Session->setFlash('Language has been deleted successfully', 'admin_flash_good');
			$this->redirect(array('action'=>'index'));		
		}
		$this->Session->setFlash('Language has not deleted', 'admin_flash_bad');
		$this->redirect(array('action' => 'index'));
	}
	/*******************************************************
	 * Active Deactive by  admin  super admin user 
	 * modified date :20-07-11
	 * Midified By Kanhaiya Dhaked  
	 * ****************************************************/
	function admin_process(){		   
	   if(!empty($this->data)){ 
	    App::import('Sanitize');
	    $action = Sanitize::escape($_POST['pageAction']);	  
        foreach ($this->data['Language'] AS $value) {	      
            if ($value != 0) {
                $ids[] = $value;				
            }
        }
		
	   if (count($this->data) == 0 || $this->data['Language'] == null) {
            $this->Session->setFlash('No items selected.', 'admin_flash_bad');
            $this->redirect(array('controller' => 'languages', 'action' => 'index'));
        }
        if($action == "delete"){
        	
        	$this->Language->deleteAll(array('Language.id'=>$ids));        	
        	$this->Session->setFlash('Languages have been deleted successfully', 'admin_flash_good');
        	$this->redirect(array('controller'=>'languages', 'action'=>'index'));
        	 
        }
		if($action == "activate"){
        	$this->Language->updateAll(array('Language.status'=>Configure::read('App.Status.active')),array('Language.id'=>$ids));
        	$this->Session->setFlash('Languages have been activated successfully', 'admin_flash_good');
        	 $this->redirect(array('controller'=>'languages', 'action'=>'index'));
        }
		if($action == "deactivate"){
        	$this->Language->updateAll(array('Language.status'=>Configure::read('App.Status.inactive')),array('Language.id'=>$ids));
        	$this->Session->setFlash('Languages have been deactivated successfully', 'admin_flash_good');
        	 $this->redirect(array('controller'=>'languages', 'action'=>'index'));
        }
	  }
	  else{
	     $this->redirect(array('controller'=>'languages', 'action'=>'index'));
	  }
	}
	
  
}  
  
  
?>