<?php
App::import('Sanitize');
class RoomFlatTypesController extends AppController {

	var $name = 'RoomFlatTypes';	
	
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	var $helpers = array('General','Form','Ajax','javascript','Paginator');
	var $components = array("Session", "Email","Auth","RequestHandler");

	var $uses	=	array('RoomFlatType');
	
	var $model = 'RoomFlatType';
	/**
	 * beforeFilter
	 *
	 * @return void
	 */	 
	 function beforeFilter(){
		parent::beforeFilter();
	 }
	function _getModelName(){
		return $this->model;
	}
	function admin_index(){
		$modelName = $this->_getModelName();
		$filters = array();		
		if(!isset($this->params['named']['page'])){
			$this->Session->delete($modelName.'Search');
		}
		if(!empty($this->data)){
			$this->Session->delete($modelName.'Search');
			if(!empty($this->data[$modelName]['name'])){
				$keyword = Sanitize::escape($this->data[$modelName]['name']);
				$this->Session->write($modelName.'Search', $keyword);				
			}				
		}

		if($this->Session->check($modelName.'Search')){		
			$filters[] = array($modelName.'.name LIKE'=>"%".$this->Session->read($modelName.'Search')."%");					
		}
		$this->paginate[$modelName] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array($modelName.'.name'=>'ASC'),
								'conditions'=>$filters
								);

		$data = $this->paginate($modelName);  
		$this->set(compact('data','modelName'));	 
		$this->set('title_for_layout',  __($modelName, true));	
		
	}
	function admin_add(){
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));
		
		$this->set('title_for_layout', __('Add New Room/Flat', true));
		if(!empty($this->data)) {
			$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);			
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('admin');
			if($this->$modelName->validates()){
				$this->$modelName->create();			
				if ($this->$modelName->save($this->data)) {				 
					$this->Session->setFlash('Record added successfully.','admin_flash_good');
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
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));
	
		if(!$id){
			$this->Session->setFlash('Invalid id','admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		$this->set('title_for_layout', __('Edit Room/Flat', true));
		if(!empty($this->data)) {
			
			$this->data[$modelName] = $this->CommonFunction->myclean($this->data[$modelName]);
		
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('admin');
			if ($this->$modelName->validates()){
				$this->$modelName->create();			
				if ($this->$modelName->save($this->data)) {				 
					$this->Session->setFlash('Record updated successfully.','admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happened.Please again try.','admin_flash_bad');				
				}
			}else{
					$this->Session->setFlash('Please remove below errors.','admin_flash_bad');				
			}
		
		}else{
			$this->data = $this->$modelName->read(null,$id);
		}	
		
	}
	function admin_delete($id = null) {
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));	

		if(!$id) {
			$this->Session->setFlash('Invalid Id', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		if($this->$modelName->delete($id)) {	 
			$this->Session->setFlash('Record Deleted successfully.', 'admin_flash_good');
			$this->redirect(array('action'=>'index'));		
		}
		$this->Session->setFlash('Any error happened.Please again try.', 'admin_flash_bad');
		$this->redirect(array('action' => 'index'));
	}
	function admin_process(){
		
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));	

		if(!empty($this->data)){
			$action = Sanitize::escape($this->data[$modelName]['pageAction']);	  
			foreach ($this->data[$modelName] AS $value) {	      
				if ($value != 0) {
					$ids[] = $value;				
				}
			}
			//pr($ids);die;
			if (count($this->data) == 0 || $this->data[$modelName] == null) {
				$this->Session->setFlash('No items selected.', 'admin_flash_bad');
				$this->redirect(array('action' => 'index'));
			}
			if($action == "delete"){
				$this->$modelName->deleteAll(array($modelName.'.id'=>$ids));        	
				$this->Session->setFlash('Records deleted successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
			if($action == "activate"){
				$this->$modelName->updateAll(array($modelName.'.status'=>Configure::read('App.Status.active')),array($modelName.'.id'=>$ids));
				$this->Session->setFlash('Records activated successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
			if($action == "deactivate"){
				$this->$modelName->updateAll(array($modelName.'.status'=>Configure::read('App.Status.inactive')),array($modelName.'.id'=>$ids));
				$this->Session->setFlash('Records deactivated successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));
			}
		}else{
			$this->redirect(array('action'=>'index'));
		}
	}	
}
?>
