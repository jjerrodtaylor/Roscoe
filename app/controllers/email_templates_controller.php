<?php
	/**
	* EmailTemplates Controller
	*
	* PHP version 5
	*
	* @category Controller
	*/
	class EmailTemplatesController extends AppController{
		/**
		* Controller name
		*
		* @var string
		* @access public
		*/
		var	$name	=	'EmailTemplates';
		/**
		* Models used by the Controller
		*
		* @var array
		* @access public
		*/	 
		var	$uses	=	array('EmailTemplate');	
		/**
		* Helpers used by the Controller
		*
		* @var array
		* @access public
		*/	
		var	$helpers	=	array('Fck');	
		/*
		* beforeFilter
		* @return void
		*/
		function beforeFilter(){
			parent::beforeFilter();			
		}

		/* List all email templates in admin panel
		*  @access public
		*/
		function admin_index(){

			if(!isset($this->params['named']['page'])){
				$this->Session->delete('AdminSearch');
			}

			$filters = array(); 
			if(!empty($this->data)){

				$this->Session->delete('AdminSearch');
				if(!empty($this->data['EmailTemplate']['name'])){
					App::import('Sanitize');
					$keyword = Sanitize::escape($this->data['EmailTemplate']['name']);
					$this->Session->write('AdminSearch', $keyword);				
				}				
			}

			if($this->Session->check('AdminSearch')){		
				$filters[] = array('EmailTemplate.name LIKE'=>"%".$this->Session->read('AdminSearch')."%");					
			}

			$this->paginate['EmailTemplate'] = array(
					'limit'=>Configure::read('App.AdminPageLimit'), 
					'order'=>array('EmailTemplate.created'=>'ASC'),
					'conditions'=>$filters
				);

			$data = $this->paginate('EmailTemplate');        		
			$this->set(compact('data'));	 
			$this->set('title_for_layout',  __('Email Template', true));	
		}

		/*Add new email template in admin panel*/
		function admin_add(){
			$this->set('title_for_layout',  __('Add Email Template', true));		
			if(!empty($this->data)) {
				// CSRF Protection
				if ($this->params['_Token']['key'] != $this->data['EmailTemplate']['token_key']) {
					$blackHoleCallback = $this->Security->blackHoleCallback;
					$this->$blackHoleCallback();
				}
				//validate and save data			
				$this->EmailTemplate->set($this->data);
				$this->EmailTemplate->setValidation('admin');
				if ($this->EmailTemplate->validates()) {				
					if ($this->EmailTemplate->save($this->data)) {				 
						$this->Session->setFlash('Email template has been saved', 'admin_flash_good');
						$this->redirect(array('controller'=>'email_templates', 'action' => 'index'));
					}else {
						$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
					}
				}else {
					$this->Session->setFlash('Email template could not be saved. Please, try again.', 'admin_flash_bad');
				}
			}
		}

		/*Edit existing email template in admin panel*/
		function admin_edit($id = null){
			$this->set('title_for_layout',  __('Edit Email Template', true));

			if(!$id && empty($this->data)) {		
				$this->Session->setFlash('Invalid newsletter id', 'admin_flash_bad');
				$this->redirect(array('controller' => 'email_templates', 'action' => 'index'));
			}		

			if(!empty($this->data)) {			
				// CSRF Protection
				if ($this->params['_Token']['key'] != $this->data['EmailTemplate']['token_key']) {
					$blackHoleCallback = $this->Security->blackHoleCallback;
					$this->$blackHoleCallback();
				}
				// validate & save data
				$this->EmailTemplate->setValidation('admin');
				if ($this->EmailTemplate->validates()) {				
					if ($this->EmailTemplate->save($this->data)) {								
						$this->Session->setFlash(__('Email template has been saved', true), 'admin_flash_good');
						$this->redirect(array('controller'=>'email_templates', 'action'=>'index'));
					}else {
						$this->Session->setFlash(__('Please correct the errors listed below.', true), 'admin_flash_bad');
					}
				}else {
					$this->Session->setFlash(__('Email template  could not be saved. Please, try again.', true), 'admin_flash_bad');
				}
			}else{
				$this->data = $this->EmailTemplate->read(null, $id);
			}
		}
		/* View email template by id in admin panel
		*  @params id
		*/
		function admin_view($id = null){

			// CSRF Protection
			if (!isset($this->params['named']['token']) || ($this->params['named']['token'] != $this->params['_Token']['key'])) {
				$blackHoleCallback = $this->Security->blackHoleCallback;
				$this->$blackHoleCallback();
			}
			if(!empty($id) && $this->EmailTemplate->hasAny(array('EmailTemplate.id' => $id))){
				$this->set('title_for_layout',  __('View Email Template', true));
				$this->data = $this->EmailTemplate->read(null, $id);
			}else{
				$this->Session->setFlash(__('Invalid email template id.', true), 'admin_flash_bad');
				$this->redirect($this->referer());
			}	
		}

	}
?>