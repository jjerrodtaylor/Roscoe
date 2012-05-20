<?php
/**
 * States Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
class StatesController extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'States';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	 var $uses	=	array('Country', 'State');
	 /**
	 * beforeFilter
	 *
	 * @return void
	 */	 
	 function beforeFilter(){
		parent::beforeFilter();	
		// CSRF Protection
        if (in_array($this->params['action'], array('admin_process'))) {
            $this->Security->validatePost = false;						
        }
		App::import('Sanitize');
			
		$this->Auth->allowedActions = array('getStateList','help');
	 }
	 
	/*
	* List all states in admin panel
	*/
	function admin_index(){
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('StateSearch');
		}
		$filters = array(); 
		if(!empty($this->data)){

			$this->Session->delete('StateSearch');
			if(!empty($this->data['State']['name'])){
				App::import('Sanitize');
				$keyword = Sanitize::escape($this->data['State']['name']);
				$this->Session->write('StateSearch', $keyword);				
			}				
		}

		if($this->Session->check('StateSearch')){		
			$filters[] = array('State.name LIKE'=>"%".$this->Session->read('StateSearch')."%");					
		}
		/*Paginate method is used to find all listing of states */
		$this->paginate['State'] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array('State.name'=>'ASC'),
								'conditions'=>$filters
								);

		$data = $this->paginate('State');        		
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('State', true));
		
	}
	
	/*
	* Add new state in admin panel
	*/
	function admin_add(){
		$this->set('title_for_layout', __('Add State', true));
		$countries	=	$this->Country->getCountryList();
		$this->set(compact('countries'));
		
		if(!empty($this->data)) {
		
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['State']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }
			//validate and save data			
			$this->State->set($this->data);
			$this->State->setValidation('admin');
			if ($this->State->validates()) {
			$this->data['State']['name']=Sanitize::paranoid($this->data['State']['name']);
			
				if ($this->State->save($this->data)) {				 
					$this->Session->setFlash('State has been saved', 'admin_flash_good');
					$this->redirect(array('controller'=>'states', 'action' => 'index'));
				} 
				else {
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}
			else {
				$this->Session->setFlash('State could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}
	}
	
	/*
	* Edit existing state in admin panel
	*/
	function admin_edit($id = null){
		$this->set("title_for_layout", __('Edit State', true));
		$countries	=	$this->Country->getCountryList();
		$this->set(compact('countries'));
		
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid state id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}		
		
		if(!empty($this->data)) {
			
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['State']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }
			// validate & save data
			 $this->State->setValidation('admin');
			 if ($this->State->validates()) {	
				$this->data['State']['name']=Sanitize::paranoid($this->data['State']['name']);
				if ($this->State->save($this->data)) {								
					$this->Session->setFlash(__('State has been saved', true), 'admin_flash_good');
					$this->redirect($this->data['State']['refererUrl']);
				} 
				else {
					$this->Session->setFlash(__('Please correct the errors listed below.', true), 'admin_flash_bad');
				}
			} 
			else {
				$this->Session->setFlash(__('State could not be saved. Please, try again.', true), 'admin_flash_bad');
			}
		}
        else{
			$this->data = $this->State->read(null, $id);
			$refererUrl	=	$this->referer();
			$this->data['State']['refererUrl'] = $refererUrl;
        }
	}
		 
	/* delete exiting states*/
	function admin_delete($id = null){
		
		if (!$id) {
            $this->Session->setFlash(__('Invalid state id', true), 'admin_flash_good');
            $this->redirect(array('action' => 'index'));
        }
		
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }	
		if ($this->State->deleteAll(array('State.id' => $id))) {
			$this->Session->setFlash(__('State has been deleted successfully', true), 'admin_flash_good');
			$this->redirect($this->referer());
		}		
	}
	 
	function admin_process(){
		if(!empty($this->data)){
		
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['State']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }			
			App::import('Sanitize');
			$action = Sanitize::escape($this->data['State']['pageAction']);	  
			foreach ($this->data['State'] AS $value) {	      
				if ($value != 0) {
						$ids[] = $value;				
				}
			}
		
			if (count($this->data) == 0 || $this->data['State'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect($this->referer());
			}
			
			if($action == "delete"){
				$this->State->deleteAll(array('State.id'=>$ids));
				$this->Session->setFlash('States have been deleted successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "activate"){
				$this->State->updateAll(array('State.status'=>Configure::read('App.Status.active')),array('State.id'=>$ids));
				$this->Session->setFlash('States have been activated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "deactivate"){
				$this->State->updateAll(array('State.status'=>Configure::read('App.Status.inactive')),array('State.id'=>$ids));
				$this->Session->setFlash('States have been deactivated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
		}
		else{
			$this->redirect(array('controller'=>'states', 'action'=>'index'));
		}
	}
	/* get state list in admin panel*/
	function admin_getStateList($data = null){
		if($this->RequestHandler->isAjax()){
			$this->autoRender = true;
			$model	=	$this->params['named']['model'];
			$country_id	=	$this->data[$model]['country_id'];
			$states = $this->State->getStateList($country_id);
			$this->set(compact('states', 'model'));
		}
	}
	/* get state list in front panel*/
	function getStateList($data = null){
		if($this->RequestHandler->isAjax()){
			$this->autoRender = true;
			$model	=	$this->params['named']['model'];
			$country_id	=	$this->data[$model]['country_id'];
			$states = $this->State->getStateList($country_id);
			$this->set(compact('states', 'model'));
		}
	}
	function admin_view_state($id=null){
			
			$this->set('title_for_layout','View State');
		
			if(isset($this->params['named']['id']) && $this->params['named']['id']!=""){
				$state_id=$this->params['named']['id'];
				$State_information =$this->State->find('all', array('conditions' => array('State.id' =>$state_id)));
				$this->set('data', $State_information);	 
					
			} 
				
	}
	 //-------------------	Start: Front end -----------------------------------
	
	
}
?>