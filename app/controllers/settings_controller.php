<?php
/**
 * Users Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
class SettingsController extends AppController{
	/**
	* Controller name
	*
	* @var string
	* @access public
	*/
	var $name = 'Settings';
	var $uses = array('Setting');
	/**
	 * Models used by the Controller
	 *
	 * @var array
	 * @access public
	*/	 
	function beforeFilter(){
		parent::beforeFilter();	 
	}
 	function admin_index()
	{
		$this->set('modelName', 'Setting');
		$this->set('controllerName', 'settings');
		
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('AdminSearch');
		}
  		$filters = array(); 
		if( !empty($this->data)){			          
			$this->Session->delete('AdminrSearch');
			$keyword = $this->data['Setting']['name'];
			if(!empty($this->data['Setting']['name'])){
				App::import('Sanitize');
				$keyword = Sanitize::escape($this->data['Setting']['name']);
				$this->Session->write('AdminSearch', $keyword);				
			}
   		}
		if($this->Session->check('AdminSearch')){
			$filters[] = array('Setting.name LIKE'=>"%".$this->Session->read('AdminSearch')."%");					
		}
		
		$settings = $this->Setting->find('all',array('conditions'=>$filters));
		$this->set('data',$settings);
	}

	function admin_edit($id = null){	
		
		$this->pageTitle = __('Edit Setting', true);	
		if(!$id && empty($this->data)) {		
			$this->Session->setFlash('Invalid setting');
			$this->redirect(array('action' => 'settings'));
		}		

		$this->set('modelName', 'Setting');
		$this->set('controllerName', 'settings');

		$res = $this->Setting->read(null, $id);
		$this->set('res',$res);
		
		if(!empty($this->data)) 
		{		
			$this->Setting->set($this->data);
     		$this->Setting->setValidation('setting');
		
			if ($this->Setting->validates()) 
			{
				if ($this->Setting->save($this->data['Setting'])){
					$this->Session->setFlash('The Setting has been saved', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}else {
				$this->Session->setFlash('The Settings could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}else{
			$this->data = $this->Setting->read(null, $id);
		}   		
	}
	function admin_add(){	
		
		$this->pageTitle = __('Add Setting', true);	

		$this->set('modelName', 'Setting');
		$this->set('controllerName', 'settings');
		
		if(!empty($this->data)) 
		{		
			$this->Setting->set($this->data);
     		$this->Setting->setValidation('setting');
		
			if ($this->Setting->validates()) 
			{
				if ($this->Setting->save($this->data['Setting'])){
					$this->Session->setFlash('The Setting has been saved', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}
			}else {
				$this->Session->setFlash('The Settings could not be saved. Please, try again.', 'admin_flash_bad');
			}
		}		
	} 	
 
}   
?>