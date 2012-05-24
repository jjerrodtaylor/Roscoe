<?php
/***********************
* Added at 29 Mar 2012
* Developed by sandeep singh
@Amenities Controller
*/
App::import('Sanitize');
class AmenitiesController extends AppController {

	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'Amenities';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	var $helpers = array('General','Form','Ajax','javascript','Paginator');
	var $components = array("Session", "Email","Auth","RequestHandler");
	 
	var $uses	=	array('Amenity');
	
	 
	/**
	 * beforeFilter
	 *
	 * @return void
	 */	 
	 function beforeFilter(){
		parent::beforeFilter();
	 }
	/*	* List all states in admin panel	*/
	 
	
	
	function admin_index()
	{		
		$this->amenity_session_check();	
		$filters = $this->get_amenity_filters();
		$this->define_amenity_pagination_defaults($filters);
		$data = $this->paginate('Amenity');  
		$this->set(compact('data'));	 
		$this->set('title_for_layout',  __('Amenity', true));	
	}
	
	function amenity_session_check()
	{
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('AmenitySearch');
		}
		
		if(!empty($this->data)){
			$this->Session->delete('AmenitySearch');
			if(!empty($this->data['Amenity']['name'])){
				$keyword = Sanitize::escape($this->data['Amenity']['name']);
				$this->Session->write('AmenitySearch', $keyword);				
			}				
		}	
	}
	
	/*
	 *Set the fileters for the amenity search if there are any 
	 */
	function get_amenity_filters()
	{
		$filters = null;
		
		if($this->Session->check('AmenitySearch')){		
			$filters[] = array('Amenity.name LIKE'=>"%".$this->Session->read('AmenitySearch')."%");					
		}

		return $filters;
	}
	
	/*
	 *Defining the pagination defaults in the $paginate controller variable. 
	 */
	function define_amenity_pagination_defaults($filters)
	{
		$this->paginate['Amenity'] = array(
			'limit' => Configure::read('App.AdminPageLimit'),
			'order' => array('Amenity.name' => 'ASC'),
			'conditions' => $filters
		);	
	}
	
	//I believe that this function allows the admin to add an amenity from the control panel
	function admin_add(){
		$this->set('title_for_layout', __('Add New Amenity', true));
		
		//if data isn't empty
		if(!empty($this->data)) {
			$this->data['Amenity'] = $this->General->myclean($this->data['Amenity']);			
			$this->Amenity->set($this->data);
			$this->Amenity->setValidation('admin');
			if($this->Amenity->validates()){
				$this->Amenity->create();			
				if ($this->Amenity->save($this->data)) {				 
					$this->Session->setFlash('Amenity has been saved','admin_flash_good');
					$this->redirect(array('controller'=>'amenities', 'action' => 'index'));
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
			$this->Session->setFlash('Invalid Amenity id','admin_flash_bad');
			$this->redirect(array('controller'=>'amenities', 'action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Amenity', true));
		if(!empty($this->data)) {
			
			$this->data['Amenity'] = $this->CommonFunction->myclean($this->data['Amenity']);
		
			$this->Amenity->set($this->data);
			$this->Amenity->setValidation('admin');
			if ($this->Amenity->validates()){
				$this->Amenity->create();			
				if ($this->Amenity->save($this->data)) {				 
					$this->Session->setFlash('Amenity has been updated','admin_flash_good');
					$this->redirect(array('controller'=>'amenities', 'action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happened.please again try.','admin_flash_bad');				
				}
			}else{
					$this->Session->setFlash('Please remove below errors.','admin_flash_bad');				
			}
		
		}else{
			$this->data = $this->Amenity->read(null,$id);
		}	
		
	}	
	
	function admin_delete($id = null) {

		if(!$id) {
			$this->Session->setFlash('Invalid Amenity Id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		if($this->Amenity->delete($id)) {	 
			$this->Session->setFlash('Amenity has been deleted successfully', 'admin_flash_good');
			$this->redirect(array('action'=>'index'));		
		}
		$this->Session->setFlash('Amenity has not deleted', 'admin_flash_bad');
		$this->redirect(array('action' => 'index'));
	}
	
	function admin_process(){		   

		if(!empty($this->data)){
			$action = Sanitize::escape($this->data['Amenity']['pageAction']);	  
			foreach ($this->data['Amenity'] AS $value) {	      
				if ($value != 0) {
					$ids[] = $value;				
				}
			}
			//pr($ids);die;
			if (count($this->data) == 0 || $this->data['Amenity'] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect(array('controller' => 'amenities', 'action' => 'index'));
			}
			if($action == "delete"){
				$this->Amenity->deleteAll(array('Amenity.id'=>$ids));        	
				$this->Session->setFlash('Amenities have been deleted successfully', 'admin_flash_good');
				$this->redirect(array('controller'=>'amenities', 'action'=>'index'));
			}
			if($action == "activate"){
				$this->Amenity->updateAll(array('Amenity.status'=>Configure::read('App.Status.active')),array('Amenity.id'=>$ids));
				$this->Session->setFlash('Amenities have been activated successfully', 'admin_flash_good');
				$this->redirect(array('controller'=>'amenities', 'action'=>'index'));
			}
			if($action == "deactivate"){
				$this->Amenity->updateAll(array('Amenity.status'=>Configure::read('App.Status.inactive')),array('Amenity.id'=>$ids));
				$this->Session->setFlash('Amenities have been deactivated successfully', 'admin_flash_good');
				$this->redirect(array('controller'=>'amenities', 'action'=>'index'));
			}
		}else{
			$this->redirect(array('action'=>'index'));
		}
	}

	
}
?>
