<?php
/**
 * Countries Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
class CountriesController extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'Countries';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	 var $uses	=	array('Country');
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
	 }	 
	/*
	* List all countries in admin panel
	*/
	function admin_index(){
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('CountrySearch');
		}
		$filters = array(); 
		if(!empty($this->data)){

			$this->Session->delete('CountrySearch');
			if(!empty($this->data['Country']['name'])){
				App::import('Sanitize');
				$keyword = Sanitize::escape($this->data['Country']['name']);
				$this->Session->write('CountrySearch', $keyword);				
			}				
		}

		if($this->Session->check('CountrySearch')){		
			$filters[] = array('Country.name LIKE'=>"%".$this->Session->read('CountrySearch')."%");					
		}
		/*Paginate method is used to find all listing of countries */
		$this->paginate['Country'] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array('Country.name'=>'ASC'),
								'conditions'=>$filters
								);

		$data = $this->paginate('Country');        		
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('Country', true));	
	}
	
	/*
	* Add new country in admin panel
	*/
	function admin_add(){
		$this->set('title_for_layout', __('Add Country', true));	
		if(!empty($this->data)) {		
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['Country']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }
			//validate and save data			
			$this->Country->set($this->data);
			$this->Country->setValidation('admin');
			if ($this->Country->validates()) {
				$this->Country->create();
				//App::import('Sanitize');
			
				$this->data['Country']['name']=Sanitize::paranoid($this->data['Country']['name']);
				if ($this->Country->save($this->data)) {				 
					$this->Session->setFlash('Country has been saved', 'admin_flash_good');
					$this->redirect(array('controller'=>'countries', 'action' => 'index'));
				} 
				else {
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}
			else {
				$this->Session->setFlash('Country could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}
	}
	
	/*
	* Edit existing country in admin panel
	*/
	function admin_edit($id =null){
		$this->set("title_for_layout", __('Edit Country', true));
		
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid country id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}		
		
		if(!empty($this->data)) {
			
			// CSRF Protection
            if ($this->params['_Token']['key'] != $this->data['Country']['token_key']) {
                $blackHoleCallback = $this->Security->blackHoleCallback;
                $this->$blackHoleCallback();
            }
			// validate & save data
			 $this->Country->setValidation('admin');
			 if ($this->Country->validates()) {	
				$this->data['Country']['name']=Sanitize::paranoid($this->data['Country']['name']);
				if ($this->Country->save($this->data)) {					
					$this->Session->setFlash(__('Country has been saved', true), 'admin_flash_good');
					$this->redirect(array('controller' => 'countries', 'action'=>'index'));
				} 
				else {
					$this->Session->setFlash(__('Please correct the errors listed below.', true), 'admin_flash_bad');
				}
			} 
			else {
				$this->Session->setFlash(__('Country could not be saved. Please, try again.', true), 'admin_flash_bad');
			}
		}
        else{
			$this->data = $this->Country->read(null, $id);
        }
	}
	
		 
	/* delete exiting country */
	function admin_delete($id = null){
		
		if (!$id) {
            $this->Session->setFlash(__('Invalid country id', true), 'admin_flash_good');
            $this->redirect(array('action' => 'index'));
        }
		
        if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
            $blackHoleCallback = $this->Security->blackHoleCallback;
            $this->$blackHoleCallback();
        }	
		if ($this->Country->deleteAll(array('Country.id' => $id))) {
			$this->Session->setFlash(__('Country has been deleted successfully', true), 'admin_flash_good');
			$this->redirect($this->referer());
		}		
	}
	 
	function admin_process(){
		if(!empty($this->data)){
		
				
			App::import('Sanitize');
			$action = Sanitize::escape($this->data['Country']['pageAction']);	  
			foreach ($this->data['Country'] AS $value) {	      
				if ($value != 0) {
						$ids[] = $value;				
				}
			}
		
			if (count($this->data) == 0 || $this->data['Country'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect($this->referer());
			}
			
			if($action == "delete"){
				$this->Country->deleteAll(array('Country.id'=>$ids));
				$this->Session->setFlash('Countries have been deleted successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "activate"){
				$this->Country->updateAll(array('Country.status'=>Configure::read('App.Status.active')),array('Country.id'=>$ids));
			
				
				$this->Session->setFlash('Countries have been activated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
			
			if($action == "deactivate"){
				$this->Country->updateAll(array('Country.status'=>Configure::read('App.Status.inactive')),array('Country.id'=>$ids));
				
				$this->Session->setFlash('Countries have been deactivated successfully', 'admin_flash_good');
				$this->redirect($this->referer());
			}
		}
		else{
			$this->redirect(array('controller'=>'countries', 'action'=>'index'));
		}
	}
	
	/* get country*/
	function getCountry(){
		if($this->RequestHandler->isAjax()){
			$this->autoRender = true;
			$model	=	$this->params['named']['model'];
			$country_id	=	$this->data[$model]['country_id'];
			$states = $this->State->getStateList($country_id);
			$this->set(compact('states', 'model'));
		}
	}

	function admin_view_country($id=null){
			
			$this->set('title_for_layout','View Country');
		
			if(isset($this->params['named']['id']) && $this->params['named']['id']!=""){
				$user_id=$this->params['named']['id'];
				$Country_information =$this->Country->find('all', array('conditions' => array('Country.id' =>$user_id)));
				$this->set('data', $Country_information);	 
					
			} 
				
	}
}
?>