<?php
/**
 * questionOptions Controller
 *
 * PHP version 5
 *
 * @questionOptions Controller
 */
App::import('Sanitize');
class QuestionOptionscontroller extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'QuestionOptions';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	var $helpers = array('General','Form','Ajax','javascript','Paginator');
	var $components = array("Session", "Email","Auth","RequestHandler");	
	 
	 var $uses	=	array('QuestionOption');
	 

	 /**
	 * beforeFilter
	 *
	 * @return void
	 */	 
	 function beforeFilter(){		
		parent::beforeFilter();
		
	 }

	function admin_index(){
		
		$filters = array('QuestionOption.parent_id'=>0);		
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('QuestionOptionSearch');
		}
		if(!empty($this->data)){
			$this->Session->delete('QuestionOptionSearch');
			if(!empty($this->data['QuestionOption']['question_option_name'])){
				$keyword = Sanitize::escape($this->data['QuestionOption']['question_option_name']);
				$this->Session->write('QuestionOptionSearch', $keyword);				
			}				
		}

		if($this->Session->check('QuestionOptionSearch')){		
			$filters[] = array('QuestionOption.question_option_name LIKE'=>"%".$this->Session->read('QuestionOptionSearch')."%");					
		}
		$this->paginate['QuestionOption'] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array('QuestionOption.question_option_name'=>'ASC'),
								'conditions'=>$filters
								);

		$data = $this->paginate('QuestionOption');  
		
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('Question Option', true));
		
		
	}
	function admin_add(){
		$this->set('title_for_layout', __('Add New Question', true));
		if(!empty($this->data)) {
			$this->data['QuestionOption'] = $this->General->myclean($this->data['QuestionOption']);			
			$this->QuestionOption->set($this->data);
			$this->QuestionOption->setValidation('admin');
			if($this->QuestionOption->validates()){
				$this->QuestionOption->create();			
				if ($this->QuestionOption->save($this->data)) {				 
					$this->Session->setFlash('Question has been saved','admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happend.Please again try.','admin_flash_bad');
				
				}
			}else{
				$this->Session->setFlash('Please remove below errors.','admin_flash_bad');
			
			}
		
		}		
	}
	
	function admin_edit($id = null){
		
		if(!$id){
			$this->Session->setFlash('Invalid Question id','admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Question', true));
		if(!empty($this->data)) {
			pr($this->data);die;
			$this->data['QuestionOption'] = $this->CommonFunction->myclean($this->data['QuestionOption']);
		
			$this->QuestionOption->set($this->data);
			$this->QuestionOption->setValidation('admin');
			if ($this->QuestionOption->validates()){
				$this->QuestionOption->create();			
				if ($this->QuestionOption->save($this->data)) {				 
					$this->Session->setFlash('Question has been updated','admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happened.please again try.','admin_flash_bad');				
				}
			}else{
					$this->Session->setFlash('Please remove below errors.','admin_flash_bad');				
			}
		
		}else{
			$this->data = $this->QuestionOption->read(null,$id);
		}	
		
	}	
	
	function admin_delete($id = null) {

		if(!$id) {
			$this->Session->setFlash('Invalid Question Id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		if($this->QuestionOption->delete($id)) {	 
			$this->Session->setFlash('Question has been deleted successfully', 'admin_flash_good');
			$this->redirect(array('action'=>'index'));		
		}
		$this->Session->setFlash('Question has not been deleted', 'admin_flash_bad');
		$this->redirect(array('action' => 'index'));
	}
	function admin_process(){		   

		if(!empty($this->data)){
			$action = Sanitize::escape($this->data['QuestionOption']['pageAction']);	  
			foreach ($this->data['QuestionOption'] AS $value) {	      
				if ($value != 0) {
					$ids[] = $value;				
				}
			}
			//pr($ids);die;
			if (count($this->data) == 0 || $this->data['QuestionOption'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect(array('action' => 'index'));
			}
			if($action == "delete"){
				$this->QuestionOption->deleteAll(array('QuestionOption.id'=>$ids));        	
				$this->Session->setFlash('Question have been deleted successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
			if($action == "activate"){
				$this->QuestionOption->updateAll(array('QuestionOption.status'=>Configure::read('App.Status.active')),array('QuestionOption.id'=>$ids));
				$this->Session->setFlash('Questions have been activated successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
			if($action == "deactivate"){
				$this->QuestionOption->updateAll(array('QuestionOption.status'=>Configure::read('App.Status.inactive')),array('QuestionOption.id'=>$ids));
				$this->Session->setFlash('Questions have been deactivated successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
		}else{
			$this->redirect(array('action'=>'index'));
		}
	}
	/*edit question options */
    function admin_edit_options($id = null)
    {
		
    	$this->pageTitle = __('Edit Options', true);
      	if(!empty($this->data)){
			
			$this->QuestionOption->set($this->data);
			$this->QuestionOption->setValidation('admin');
      		if($this->QuestionOption->validates($this->data)){ 
				$this->QuestionOption->create();
				if($this->QuestionOption->saveAll($this->data["QuestionOption"])){
	        		$this->Session->setFlash('Options has been updated successfully.','admin_flash_good');
	        	}else{
					$this->Session->setFlash('Any error happened.Please again try.','admin_flash_bad');
	        	}
				
        	}else{
        		$this->Session->setFlash('Any field cannot be left blank','admin_flash_bad');
        	}
        }
				
      	$this->data = $this->QuestionOption->find(
												'first',
												array(
													'conditions'=>array(
      													'QuestionOption.id'=>$id,
      													)
      											));
									
		
      	
    }

	function admin_delete_option($question_id = null,$option_id = null){
    	$this->QuestionOption->delete(array('QuestionOption.id'=>$option_id));
    	$this->redirect(array('controller'=>'question_options','action'=>'edit_options',$question_id));
    }	

}
?>