<?php
/**
 * Cities Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
class CitiesController extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'Cities';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	 var $uses	=	array('City', 'Country', 'State');
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
		$this->Auth->allowedActions = array('getCityList');	
	 }
	 
	/*
	* List all cities in admin panel
	*/
	function admin_index(){
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('CitySearch');
		}
		$filters = array(); 
		if(!empty($this->data)){
			$this->Session->delete('CitySearch');
			if(!empty($this->data['City']['name'])){
				App::import('Sanitize');
				$keyword = Sanitize::escape($this->data['City']['name']);
				$this->Session->write('CitySearch', $keyword);				
			}				
		}

		if($this->Session->check('CitySearch')){		
			$filters[] = array('City.name LIKE'=>"%".$this->Session->read('CitySearch')."%");					
		}
		/*Paginate method is used to find all listing of cities */
		$this->paginate['City'] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array('City.name'=>'ASC'),
								'conditions'=>$filters
								);

		$data = $this->paginate('City');        		
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('City', true));	
	}
	
	/*
	* Add new city in admin panel
	*/
	function admin_add(){
		$this->set('title_for_layout', __('Add City', true));		
		
		if(!empty($this->data)) {
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['City']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }
			//validate and save data			
			$this->City->set($this->data);
			$this->City->setValidation('admin');
			if ($this->City->validates()) {				
				if ($this->City->save($this->data)) {				 
					$this->Session->setFlash('City has been saved', 'admin_flash_good');
					$this->redirect(array('controller'=>'cities', 'action' => 'index'));
				} 
				else {
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}
			else {
				$this->Session->setFlash('City could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}
		$countries	=	$this->Country->getCountryList();
		$this->set(compact('countries'));
		if(isset($this->data['City']['country_id'])){
			$states		=	$this->State->getStateList($this->data['City']['country_id']);	
			$this->set(compact('states'));
		}		
	}	
	/*
	* Edit existing city in admin panel
	*/
	function admin_edit($id = null){
		$this->set("title_for_layout", __('Edit City', true));
		
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid city id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}		
		
		if(!empty($this->data)) {
			
			$this->City->setValidation('admin');
			 if ($this->City->validates()) {					
				if ($this->City->save($this->data)) {								
					$this->Session->setFlash(__('City has been saved', true), 'admin_flash_good');
					$this->redirect(array('controller' => 'cities', 'action'=>'index'));
				} 
				else {
					$this->Session->setFlash(__('Please correct the errors listed below.', true), 'admin_flash_bad');
				}
			} 
			else {				
				$this->Session->setFlash(__('City could not be saved. Please, try again.', true), 'admin_flash_bad');
			}
		}
        else{
			$this->data = $this->City->read(null, $id);			
        }
		$countries	=	$this->Country->getCountryList();
		$states		=	$this->State->getStateList($this->data['City']['country_id']);	
		$this->set(compact('countries'));
		$this->set(compact('states'));
	}
	 /* delete existing cities*/
	 function admin_delete($id = null){
		
		if (!$id) {
            $this->Session->setFlash(__('Invalid id of city', true), 'admin_flash_good');
            $this->redirect(array('action' => 'index'));
        }
		
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }	
		if ($this->City->deleteAll(array('City.id' => $id))) {
			$this->Session->setFlash(__('City has been deleted successfully', true), 'admin_flash_good');
			$this->redirect($this->referer());
		}		
	 }
	 
	function admin_process(){
	
		if(!empty($this->data)){			
			App::import('Sanitize');
			$action = Sanitize::escape($this->data['City']['pageAction']);	  
			foreach ($this->data['City'] AS $value) {	      
				if ($value != 0) {
						$ids[] = $value;				
				}
			}
		
			if (count($this->data) == 0 || $this->data['City'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect($this->referer());
			}
			
			if($action == "delete"){
				$this->City->deleteAll(array('City.id'=>$ids));
				$this->Session->setFlash('Cities have been deleted successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "activate"){
				$this->City->updateAll(array('City.status'=>Configure::read('App.Status.active')),array('City.id'=>$ids));
				$this->Session->setFlash('Cities have been activated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "deactivate"){
				$this->City->updateAll(array('City.status'=>Configure::read('App.Status.inactive')),array('City.id'=>$ids));
				$this->Session->setFlash('Cities have been deactivated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
		}
		else{
			$this->redirect(array('controller'=>'cities', 'action'=>'index'));
		}
	}
	
	/* get city list in admin panel*/
	function admin_getCityList($data = null){
		if($this->RequestHandler->isAjax()){
			$this->autoRender = true;
			$model	=	$this->params['named']['model'];
			if(isset($this->data[$model]['state_id'])){
				$state_id	=	$this->data[$model]['state_id'];
				$cities = $this->City->getCityList($state_id);				
			}
			$this->set(compact('cities', 'model'));	
		}
	}
	/* get city list in admin panel*/
	function getCityList($data = null){
		if($this->RequestHandler->isAjax()){
			$this->autoRender = true;
			$model	=	$this->params['named']['model'];
			if(isset($this->data[$model]['state_id'])){
				$state_id	=	$this->data[$model]['state_id'];
				$cities = $this->City->getCityList($state_id);				
			}
			$this->set(compact('cities', 'model'));	
		}
	}
	function admin_view_city($id=null){
			
			$this->set('title_for_layout','View City');
		
			if(isset($this->params['named']['id']) && $this->params['named']['id']!=""){
				$city_id=$this->params['named']['id'];
				$city_information =$this->City->find('all', array('conditions' => array('City.id' =>$city_id)));
				$this->set('data', $city_information);	 
					
			} 
				
	}
}
?>