<?php
	/**
	* Registers Controller
	*
	* PHP version 5
	*
	* @category Controller
	*/
	class RegistersController extends AppController{
		/**
		* Controller name
		* @var string
		* @access public
		*/
		var $name = 'Registers';
		/**
		* Models used by the Controller
		* @var array
		* @access public
		*/	
		var $uses =array('User','UserReference','State','Country');
		var $helpers = array('General');
		var $components = array('Upload','RequestHandler');
		function beforeFilter(){
			parent::beforeFilter();	 
			$this->Auth->allow('activate_forgetpass','forget_password','view_image','login','logout','signup','popup_signup','activate');
		}
		function admin_index(){

			if(!isset($this->params['named']['page'])){
				$this->Session->delete('Registersearch');
			}
			$filters[] = array('User.role_id'=>Configure::read('App.Role.User')); 
			if( !empty($this->data)){			          
				$this->Session->delete('AdminrSearch');
				$keyword = $this->data['UserReference']['first_name'];
				if(!empty($this->data['UserReference']['first_name'])){
					App::import('Sanitize');
					$keyword = Sanitize::escape($this->data['UserReference']['first_name']);
					$this->Session->write('Registersearch', $keyword);				
				}
			}
			if($this->Session->check('Registersearch')){
				$first_name = array('UserReference.first_name LIKE'=>"%".$this->Session->read('Registersearch')."%");					
				$last_name = array('UserReference.last_name LIKE'=>"%".$this->Session->read('Registersearch')."%");					
				$filters[] = array('OR'=>array($first_name,$last_name));
			}
			$this->paginate['User'] = array(
					'limit'=>Configure::read('App.AdminPageLimit'), 
					'order'=>array('User.id'=>'DESC'),
					'conditions'=>$filters
				);
				
			$result = $this->paginate('User');        
			$this->set('data', $result);	 
			$this->set('title_for_layout', 'User');
		}
		function admin_add() {

			$this->loadModel('UserImage');
			$this->set('title_for_layout', 'Add User');
			if(!empty($this->data)) 
			{
				//prd($this->data);
				$this->data['User'] 			= $this->General->myclean($this->data['User']);
				$this->data['UserReference'] 	= $this->General->myclean($this->data['UserReference']);

				$this->User->set($this->data);
				$this->User->setValidation('admin');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('admin');
				$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
				
				if($this->User->saveAll($this->data,array('validate'=>'first'))) 
				{
					$this->Session->setFlash('User has been saved', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
				}			
				$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['UserReference']['country_id'])));
				$this->set(compact('states'));				
				$hash = $this->data['User']['hash'];
				//prd($this->data['UserImage']);
			}else{
				unset($this->data['User']['username']);
				$hash = $this->_randomPrefix(20);	
			}
			 
			$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
			$this->set(compact('countries','hash'));
		}
		function admin_edit($id = null) {
			$this->loadModel('UserImage');
			$this->set('title_for_layout', 'Edit User');	
			if(!$id && empty($this->data)) {		
				$this->Session->setFlash('Invalid User Id');
				$this->redirect(array('action' => 'index'));
			}		
			if(!empty($this->data)){
				//pr($this->data);die;
				$this->data['User'] = $this->General->myclean($this->data['User']);
				$this->data['UserReference'] = $this->General->myclean($this->data['UserReference']);

				$this->User->set($this->data);
				$this->User->setValidation('admin');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('admin');
				if($this->User->validates() && $this->UserReference->validates()) {
					if ($this->User->saveAll($this->data)){	

						/* update profile status */
						$this->_updateUserImagProfileStatus($this->data);
						$this->Session->setFlash('The User has been updated successfully', 'admin_flash_good');
						$this->redirect(array('action' => 'index'));
					}else{
						$this->Session->setFlash('The User could not be updated. Please, try again.', 'admin_flash_bad');
						$this->_getUserImages($id);
					}
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'admin_flash_bad');
					$this->_getUserImages($id);
				}		
				$selected_country_id = $this->data['UserReference']['country_id'];

			}else{
				$this->data = $this->User->read(null, $id);
				$selected_country_id = $this->data['UserReference']['country_id'];
			}
			$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
			$states=$this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$selected_country_id),'fields'=>array('id','name')));
			$this->set(compact('states','countries'));
			//echo '<pre>';
			//print_r($this->data);die;
			
		}
		function _updateUserImagProfileStatus($data = null){
			/* ==========update profile images=========== */
			$this->loadModel('UserImage');
			$this->UserImage->unbindModel(array('belongsTo'=>array('User')),false);
			if(isset($data['Image']['default'])){
				$this->UserImage->updateAll(array('UserImage.profile_default'=>0),array('UserImage.user_id'=>$data['User']['id']));					
				$this->UserImage->updateAll(array('UserImage.profile_default'=>'1'),array('UserImage.id'=>$data['Image']['default']));
				return true;			
			}
			/* ==================end here=================== */		
		}
		function _getUserImages($user_id = null){
			/* ==========get images for a particular useres=========== */
			if($user_id){
				$this->loadModel('UserImage');
				$this->UserImage->unbindModel(array('belongsTo'=>array('User')),false);
				$data = $this->UserImage->find('all',array('conditions'=>array('UserImage.user_id'=>$user_id)));
				$dataArr = array();
				if(!empty($data)){
					foreach($data as $key=>$value){
						$dataArr['UserImage'][] = $value['UserImage'];
					}
					$this->data['UserImage'] = $dataArr['UserImage'];
				}else{
					$this->data['UserImage'] = array();
				}
				
				//pr($this->data);die;
			}
			/* ==================end here=================== */		
		}		
		function admin_delete($id = null) {
			
			if(!$id) {
				$this->Session->setFlash('Invalid id for Admin');
				$this->redirect(array('action'=>'index'));
			}
			$admin = $this->User->read(null, $id);
			if(empty($admin)) {
				$this->Session->setFlash('Invalid User Id', 'admin_flash_bad');
				$this->redirect(array('action' => 'index'));
			}

			if($this->User->delete($id)) {	 
				$this->Session->setFlash('User has been deleted successfully', 'admin_flash_good');
				$this->redirect(array('action'=>'index'));		
			}
			$this->Session->setFlash('User has not been deleted', 'admin_flash_bad');
			$this->redirect(array('action' => 'index'));
		}
		function admin_process(){	
			if(!empty($this->data)){ 
				App::import('Sanitize');
				$action = Sanitize::escape($_POST['pageAction']);	  
				foreach ($this->data['User'] AS $value) {	      
					if ($value != 0) {
						$ids[] = $value;				
					}
				}

				if (count($this->data) == 0 || $this->data['User'] == null) {
					$this->Session->setFlash('No items selected.', 'admin_flash_bad');
					$this->redirect(array('controller' => 'Registers', 'action' => 'index'));
				}
				if($action == "delete"){

					$this->User->deleteAll(array('User.id'=>$ids));        	
					$this->Session->setFlash('User have been deleted successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Registers', 'action'=>'index'));

				}
				if($action == "activate"){
					$this->User->updateAll(array('User.status'=>Configure::read('App.Status.active')),array('User.id'=>$ids));
					$this->Session->setFlash('User have been activated successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Registers', 'action'=>'index'));
				}
				if($action == "deactivate"){
					$this->User->updateAll(array('User.status'=>Configure::read('App.Status.inactive')),array('User.id'=>$ids));
					$this->Session->setFlash('User have been deactivated successfully', 'admin_flash_good');
					$this->redirect(array('controller'=>'Registers', 'action'=>'index'));
				}
			}else{
				$this->redirect(array('controller'=>'Registers', 'action'=>'index'));
			}
		}
		function admin_changepassword($id = null){
		
			$this->set('title_for_layout', 'Change Password');     
			if (!$id && empty($this->data)) {
				$this->Session->setFlash(__('Invalid User', true));
				$this->redirect(array('action' => 'index'));
			}
			if(!empty($this->data)){
				$this->User->set($this->data);
				$this->User->setValidation('change_password');
				if($this->User->validates()){
					$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
					$this->User->updateAll(array('password'=>"'".$this->data['User']['password']."'"), array('User.id'=>$id));
					$this->Session->setFlash('Password has been changed successfully', 'admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}
			}else{
				$this->data = $this->User->read(null, $id);
			}          

		}
		/* =============================Add images===================================== */
		function admin_addimage($user_id = null){
			if(!$user_id){			
				$this->Session->setFlash('Invalid Id','admin_flash_good');
				$thsi->redirect(array('action'=>'index'));
			}else{
			
				if(!empty($this->data)){
					$this->loadModel('UserImage');
					
					$data = $this->UserImage->setUserId($this->data['UserImage'],$user_id);
					if($this->UserImage->saveAll($data)){
						$this->Session->setFlash('Images saved successfully.','admin_flash_good');
						$this->redirect(array('action'=>'index'));						
					}else{
						$this->Session->setFlash('Not found images for saving.','admin_flash_good');
						$thsi->redirect(array('action'=>'index'));					
					}
					
					
				}else{
					
					$this->loadModel('UserImage');
					$this->UserImage->unbindModel(array('belongsTo'=>array('User')),false);
					$userImageArr = $this->UserImage->find('all',array('UserImage.user_id'=>$user_id));
					if(count($userImageArr) >0){
						$hash = $userImageArr[0]['UserImage']['hash'];
					}else{
						
						$hash = $this->_randomPrefix(20);
					}
					//prd(count($userImageArr));die;
					$this->set(compact('userImageArr','hash','user_id'));
				}
				
			}		
		
		}

		function _randomPrefix($length)
		{
			$random= "";
			
			srand((double)microtime()*1000000);

			$data = "AbcDE123IJKLMN67QRSTUVWXYZ";
			$data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
			$data .= "0FGH45OP89";

			for($i = 0; $i < $length; $i++)
			{
				$random .= substr($data, (rand()%(strlen($data))), 1);
			}

			return $random;

		}
		function state(){
		
			if($this->RequestHandler->isAjax()){
				Configure::write('debug',0);
				$country_id = $_REQUEST['country_id'];
				$action = $_REQUEST['action'];
				$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$country_id)));
				$this->set(compact('states','action'));
				$view = $this->render('/elements/registreduser/state');
				$this->layout ='';
				$this->render(false);
				echo json_encode(array('value'=>$view));
				exit();	
			}
		}

		function admin_question_answer($user_id = null){
			$this->loadModel('QuestionOption');
			$this->loadModel('QuestionOptionsUser');
			if(!empty($this->data)){
				$i = 0;
				$dataArr = '';
				foreach($this->data['QuestionOption'] as $key=>$value){
					if(!empty($value)){
						
						$dataArr['QuestionOption'][$i]['user_id']= $this->data['User']['user_id'];
						$dataArr['QuestionOption'][$i]['question_option_id']= $value;
						$i++;
						
					}
				}
				$this->QuestionOptionsUser->deleteAll(array('QuestionOptionsUser.user_id'=>$this->data['User']['user_id']));
				
				if(!empty($dataArr)){
					$this->QuestionOptionsUser->saveAll($dataArr['QuestionOption']);
					$this->Session->setFlash('Answer has been updated successfully.','admin_flash_good');
				}
				$this->redirect(array('action'=>'index'));			
			}
			
			$data = $this->QuestionOption->find('all',array('conditions'=>array('QuestionOption.status'=>1)));
			$select = $this->QuestionOptionsUser->find('list',array('conditions'=>array('QuestionOptionsUser.user_id'=>$user_id),'fields'=>array('question_option_id','question_option_id')));
			$this->set('user_id',$user_id);
			$this->set(compact('data','select'));
			//pr($data);die;
			$this->layout = false;		
			
		}
		/*************** Front page********************************** */
		function login(){			
			$this->set('title_for_layout','Login');	
			if ($this->Auth->user()) {
				if (!empty($this->data['User']['remember_me'])) 
				{
					//pr($this->Auth);die;
					$cookie = array();
					$cookie['username'] = $this->data['User']['username'];
					//$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
					$cookie['password'] = $this->data['User']['password'];
					$this->Cookie->write('Auth.User', $cookie, true, '+2 weeks');
					unset($this->data['User']['remember_me']);
				}
				else
				{	
					$cookie = $this->Cookie->read('Auth.User');
					if (!is_null($cookie)) {
						$this->Cookie->delete('Auth.User');
					}
				}
				$this->redirect($this->Auth->redirect());
			}
			
			if (empty($this->data)) {
				
				$cookie = $this->Cookie->read('Auth.User');
				if (!is_null($cookie)) {
					$this->data['User']['username'] = $cookie['username'];
					$this->data['User']['password'] = $cookie['password'];
				}
			}
		}
		function logout(){
			$this->redirect($this->Auth->logout());

		}
		/* *************************Sign up processing**************************** */
		/* ********************************************************************** */
		function signup(){			
			$this->set('title_for_layout','Sign-Up User');  
			if(!empty($this->data)) {
			
				$activationKey = substr(md5(uniqid()), 0, 20);	
				$this->data['User']['activation_key']  = $activationKey;			
				
				$this->data['User']['role_id'] = Configure::read('App.Role.User');
				$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
				$this->User->set($this->data);
				$this->User->setValidation('front');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('front');				
				if($this->User->saveAll($this->data,array('validate'=>'first'))) {					
					$this->_signupEmail();
					$this->Session->setFlash('Your account has been created and you will get a account activation mail on your email account, click on the link and it will activate your account','flash_good');
					$this->redirect(array('controller'=>'fronts','action'=>'index'));
					//unset($this->data);
				}else{
					$this->Session->setFlash('Please correct the errors listed below.', 'flash_bad');
				}

			}		
		}
		function popup_signup(){
			Configure::write('debug',0);
			$this->set('title_for_layout','Sign-Up User');  
			if(!empty($this->data)) {
				$this->data = $_REQUEST['data'];
				$activationKey = substr(md5(uniqid()), 0, 20);	
				$this->data['User']['activation_key']  = $activationKey;			
				
				$this->data['User']['role_id'] = Configure::read('App.Role.User');
				$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
				$this->User->set($this->data);
				$this->User->setValidation('front');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('front');				
				if($this->User->saveAll($this->data,array('validate'=>'first'))) {					
					$this->_signupEmail();
					$reponseArr['Session']['setFlash'] = 'Your account has been created and you will get a account activation mail on your email account, click on the link and it will activate your account';
					$reponseArr['Session']['element'] = 'flash_good';					
					unset($this->data);
				}else{
					$reponseArr['Session']['setFlash'] = 'Please correct the errors listed below.';
					$reponseArr['Session']['element'] = 'flash_bad';			
				}
				if($this->RequestHandler->isAjax()){
					$this->_popupSignUpAjaxResponse($reponseArr);
				}				
			}
			$this->layout = '';
		}
		/* popup_sign up ajax reponse processing */
		function _popupSignUpAjaxResponse($reponseArr){
			$this->layout = '';
			$this->render(false);
			$this->disableCache();
			/* Set error messages */			
			if(isset($this->UserReference->validationErrors['terms_condtions'])){
				$reponseArr['UserReference']['terms_condtions'] = $this->UserReference->validationErrors['terms_condtions'];
			}else{
				$reponseArr['UserReference']['terms_condtions'] = '';
			}
			if(isset($this->User->validationErrors['email'])){
				$reponseArr['User']['email'] = $this->User->validationErrors['email'];
			}else{
				$reponseArr['User']['email'] = '';
			}
			if(isset($this->User->validationErrors['password2'])){
				$reponseArr['User']['password2'] = $this->User->validationErrors['password2'];
			}else{
				$reponseArr['User']['password2'] = '';
			}
			if(isset($this->User->validationErrors['confirm_password'])){
				$reponseArr['User']['confirm_password'] = $this->User->validationErrors['confirm_password'];
			}else{
				$reponseArr['User']['confirm_password'] = '';
			}
			
			/* End here */		
			echo json_encode(array('value'=>$reponseArr));
			exit();		
		}
		/* Send Activation email to user */
		function _signupEmail(){		
			$this->loadModel('EmailTemplate');
			$mailMessage="";
			$message = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.slug'=>'user_register'))); 
			$activation_url = Router::url(array(
					'controller' => 'registers',
					'action' => 'activate',
					$this->data['User']['email'],
					$this->data['User']['activation_key'],
				), true);
			$activation_link	=	'<a href='.$activation_url.'>'.$this->data['User']['activation_key'].'</a>';
			$mailMessage = str_replace(array('{name}','{username}', '{activation_key}', '{password}'), array('xxxx',$this->data['User']['email'], $activation_link, $this->data['User']['password2']), $message['EmailTemplate']['description']);					
			/* sending  mail to client for confirmation   */
			$this->set('message',$mailMessage);
			$this->Email->to =	$this->data['User']['email'] ;
			$this->Email->from  = Configure::read('App.AdminMail');;
			$this->Email->subject = $message['EmailTemplate']['subject'];
			$this->Email->template = 'user_register';
			$this->Email->sendAs = 'html';		
			$this->Email->send();			
		}			
		/* For Activate sign up status */
 		function activate($email = null, $activation_key = null){	     
			if ($email == null || $activation_key == null) {
				$this->Session->setFlash(__('User does not exist in our database.',true), 'flash_bad');
				$this->redirect(array('action' => 'signup'));
			}
			if ($this->User->hasAny(array('User.email' => $email,'User.activation_key' => $activation_key,'User.status' =>'0')))
			{
				$user = $this->User->findByEmail($email);
				$activation_key =  md5(uniqid());
				$this->User->updateAll(array(
				'User.status'=>'1',
				'User.activation_key'=>"'".$activation_key."'"), 
				array('User.id'=>$user['User']['id']));

				$this->Session->setFlash('Account has been activated successfully.You could login.', 'flash_good');
				$this->redirect(array('action' => 'signup'));
			}
			else{
				$this->Session->setFlash(__('Account has not activated.',true), 'flash_bad');			
				$this->redirect(array('controller' => 'users', 'action' => 'login'));
			}
		} 
	
		/* *************************Sign up processing**************************** */
		/* ******************************End here********************************* */
		
		function my_account(){
			$this->User->recursive = 2;
			$this->User->UserImage->unbindModel(array('belongsTo'=>array('User')),false);			
			$this->UserReference->unbindModel(array('belongsTo'=>array('User')),false);
			$this->UserReference->bindModel(array('belongsTo'=>array('Country','State')),false);
			$data = $this->User->read(null,$this->Auth->user('id'));
			$this->set(compact('data'));
			$this->layout = 'home';
			//prd($data);

		}
		/* edit user info */
		function edit() {
			
			$this->loadModel('UserImage');
			$this->set('title_for_layout', 'Edit Account Detail');	
			$this->layout = 'home';
			
			if(!empty($this->data)){
				//pr($this->data);die;
				$this->data['User']['role_id'] = 2;
				$this->data['User'] = $this->General->myclean($this->data['User']);
				$this->data['UserReference'] = $this->General->myclean($this->data['UserReference']);

				$this->User->set($this->data);
				$this->User->setValidation('front');
				$this->UserReference->set($this->data);
				$this->UserReference->setValidation('front');
				
				//pr($this->data);die;
				if($this->User->validates() && $this->UserReference->validates()) {
					if ($this->User->saveAll($this->data)){
						/* update profile status */
						$this->_updateUserImagProfileStatus($this->data);
						
						$this->Session->setFlash('Data has been updated successfully', 'flash_good');
						$this->redirect(array('action' => 'my_account','#middle'));
					}else{
						$this->_getUserImages($this->Auth->user('id'));
						$this->Session->setFlash('Data could not be updated. Please, try again.', 'flash_bad');
					}
				}else{
					$this->_getUserImages($this->Auth->user('id'));
					$this->Session->setFlash('Please correct the errors listed below.', 'flash_bad');
				}		
				$selected_country_id = $this->data['UserReference']['country_id'];

			}else{
				$this->data = $this->User->read(null, $this->Auth->user('id'));
				$selected_country_id = $this->data['UserReference']['country_id'];
				//pr($this->data);die;
			}
			$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
			$states=$this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$selected_country_id),'fields'=>array('id','name')));
			$this->set(compact('states','countries'));
			//pr($this->UserReference->validationErrors);die;
		}
		/* =======================image show both in admin and front after deleting====================================== */
		function view_image(){
			Configure::write('debug',0);
			if($this->RequestHandler->isAjax()){
				$this->loadModel('UserImage');
				$id = $_REQUEST['id'];
				
				$this->UserImage->unbindModel(array('belongsTo'=>array('User')),false);
				$data = $this->UserImage->read(null,$id);				
				/* delete record from table */
				$this->UserImage->delete(array('UserImage.id'=>$id));				
				
				/* delete image form image folder */
				$this->UserImage->deleteImages($data);	
				
				$this->layout ='';
				$this->render(false);
				echo json_encode(array('value'=>'1'));
				exit();		
			
			}
		
		}
		/* ====================Add images in front===================== */
		function addimage($user_id = null){
			if(!$user_id){			
				$this->Session->setFlash('Invalid Id','flash_good');
				$thsi->redirect(array('action'=>'edit','#middle'));
			}else{
			
				if(!empty($this->data)){
					$this->loadModel('UserImage');
					
					$data = $this->UserImage->setUserId($this->data['UserImage'],$user_id);
					if($this->UserImage->saveAll($data)){
						$this->Session->setFlash('Images saved successfully.','flash_good');
						$this->redirect(array('action'=>'edit','#middle'));						
					}else{
						$this->Session->setFlash('Not found images for saving.','flash_good');
						$thsi->redirect(array('action'=>'edit','#middle'));					
					}
					
					
				}else{
					
					$this->loadModel('UserImage');
					$this->UserImage->unbindModel(array('belongsTo'=>array('User')),false);
					$userImageArr = $this->UserImage->find('all',array('UserImage.user_id'=>$user_id));
					if(count($userImageArr) >0){
						$hash = $userImageArr[0]['UserImage']['hash'];
					}else{
						
						$hash = $this->_randomPrefix(20);
					}
					//prd(count($userImageArr));die;
					$this->set(compact('userImageArr','hash','user_id'));
				}
				
			}		
		
		}
		/* ==============update question's answer form front======= */
		function question_answer($user_id = null){
			$this->loadModel('QuestionOption');
			$this->loadModel('QuestionOptionsUser');
			if(!empty($this->data)){
				$i = 0;
				$dataArr = '';
				foreach($this->data['QuestionOption'] as $key=>$value){
					if(!empty($value)){
						
						$dataArr['QuestionOption'][$i]['user_id']= $this->data['User']['user_id'];
						$dataArr['QuestionOption'][$i]['question_option_id']= $value;
						$i++;
						
					}
				}
				$this->QuestionOptionsUser->deleteAll(array('QuestionOptionsUser.user_id'=>$this->data['User']['user_id']));
				
				if(!empty($dataArr)){
					$this->QuestionOptionsUser->saveAll($dataArr['QuestionOption']);
					$this->Session->setFlash('Answer has been updated successfully.','flash_good');
				}
				$this->redirect(array('action'=>'edit','#middle'));			
			}
			
			$data = $this->QuestionOption->find('all',array('conditions'=>array('QuestionOption.status'=>1)));
			$select = $this->QuestionOptionsUser->find('list',array('conditions'=>array('QuestionOptionsUser.user_id'=>$user_id),'fields'=>array('question_option_id','question_option_id')));
			$this->set('user_id',$user_id);
			$this->set(compact('data','select'));
			$this->layout = false;		
			
		}
		/* ===========added at 1-5-12==================== */
		/*
		* contact owner pop-up 
		* at search page.
		*/
		function contact_owner($id = null){
			if(!$id){
				$this->Session->setFlash('Invalid Id','flash_bad');
			}else{
				$this->User->recursive = 2;
				$this->User->UserImage->unbindModel(array('belongsTo'=>array('User')),false);			
				$this->UserReference->unbindModel(array('belongsTo'=>array('User')),false);
				$this->UserReference->bindModel(array('belongsTo'=>array('Country','State')),false);
				$data = $this->User->read(null,$id);
				$this->set(compact('data'));
				//pr($data);die;
			}
			$this->layout = 'ajax';
		}
		/* ===========added at 8-5-12==================== */
		/*
		* forget password
		*/	
		function forget_password(){
			Configure::write('debug',0);
			$this->set('title_for_layout','Forget-Password'); 
			$message_type = 'flash_bad';
			if(isset($_REQUEST['email'])){
				
				$this->data['User']['email'] = $_REQUEST['email'];
				$this->User->set($this->data);
				$this->User->setValidation('forget_password');
				if($this->User->validates($this->data)){
					$this->User->unbindModel(array('hasMany'=>array('UserImage')),false);
					$user_details = $this->User->find("first", array("conditions" => array("User.email" => $this->data["User"]["email"],'User.role_id'=>2,'User.status'=>1)));
					//print_r(count($user_details));die;
					if(count($user_details) >1){
						$activationKey = substr(md5(uniqid()), 0, 20);						
											
						/*Email to user */
						
						$this->loadModel('EmailTemplate');
	
						$mailMessage="";
						
						$message = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.slug'=>'forget_password'))); 
						
						$activation_url = Router::url(array(
								'controller' => 'registers',
								'action' => 'activate_forgetpass',
								$user_details['User']['email'],
								$activationKey
							), true);
						$activation_link	=	'<a href='.$activation_url.'>'.$activation_url.'</a>';
						//echo $activation_link;die;
						$mailMessage = str_replace(array('{activation_key}'), array($activation_link), $message['EmailTemplate']['description']);					
						/* sending  mail to client for confirmation   */
						$this->set('message',$mailMessage);			
						$this->Email->to      = $this->data["User"]["email"];
						$this->Email->from    = Configure::read('App.AdminMail');
						$this->Email->subject = $message['EmailTemplate']['subject'];
						$this->Email->sendAs = 'html';						
						$this->Email->template = "forgot_password";						
						if($this->Email->send()){
							$message = 'you will get a mail on your email account, click on the link and you will get other email with new password';
							$message_type = 'flash_good';
							$this->User->id = $user_details['User']['id'];
							$this->User->saveField('activation_key',$activationKey);					
						
						}else{
							$message = 'Problem in sending mail.Please again try.';															
						}
					}else{
						$message = 'This email address is not registered with us.';
							
					}
				}else{
					$message =  $this->User->validationErrors['email'];											
				}
				$this->layout = '';
				$this->render(false);
				$this->disableCache();				
				echo json_encode(array('message'=>$message,'message_type'=>$message_type));

			}
			$this->layout = '';		
		}
		/* active forget password 
		* after sending forget password link.
		*/
		function activate_forgetpass($email = null, $activation_key = null){	     
				
 				if ($email == null || $activation_key == null) {
					$this->redirect(array('action'=>'login'));
				}
				if ($this->User->hasAny(array('User.role_id'=>2,'User.status'=>1,'User.email' => $email,'User.activation_key' => $activation_key)))
				{
					$this->User->unbindModel(array('hasMany'=>array('UserImage')),false);
					$user = $this->User->findByEmail($email);
					$this->loadModel('EmailTemplate');
					
					$mailMessage="";
					
					$message = $this->EmailTemplate->find('first',array('conditions'=>array('EmailTemplate.slug'=>'reset_password'))); 
					
					$new_pass = $this->_randomPrefix(8);
					$hash_new_pass = $this->Auth->password($new_pass);
							
					$activation_url = Router::url(array(
							'controller' => 'registers',
							'action' => 'login'						
						), true);
					$activation_link	=	'<a href='.$activation_url.'>'.$activation_url.'</a>';
					$mailMessage = str_replace(array('{username}', '{activation_key}', '{password}'), array($user['User']['email'], $activation_link, $new_pass), $message['EmailTemplate']['description']);					
					/* sending  mail to client for confirmation   */
					$this->set('message',$mailMessage);		
					
					$this->Email->to      = $user["User"]["email"];
					$this->Email->from    = Configure::read('App.AdminMail');
					$this->Email->subject = $message['EmailTemplate']['subject'];;
					$this->Email->sendAs = 'html';
					$this->Email->template = "reset_password";						
					if($this->Email->send()){
						$activation_key =  md5(uniqid());						
						$this->User->updateAll(array('User.activation_key'=>"'".$activation_key."'",'User.password'=>"'".$hash_new_pass."'"),array('User.id'=>$user['User']['id']));
						/* automatically login */						
						$this->Session->write($this->Auth->sessionKey, $user['User']);
						$this->Auth->_loggedIn = true;
						$this->Session->setFlash('Check your email for new login details..','flash_good');
						$this->redirect(array('action'=>'my_account'));
					
					}else{
						$this->redirect(array('action'=>'login'));															
					}				
				
				}else{
					
					$this->redirect(array('action'=>'login'));					
				}		
				

		}
		function change_password(){
		
			$this->set('title_for_layout', 'Change Password');     
			if(!empty($this->data)){
				$this->User->set($this->data);
				$this->User->setValidation('change_password');
				if($this->User->validates()){
					$this->data['User']['password'] = Security::hash($this->data['User']['password2'], null, true);
					$this->User->updateAll(array('password'=>"'".$this->data['User']['password']."'"), array('User.id'=>$this->Auth->user('id')));
					$this->Session->setFlash('Password has been changed successfully', 'flash_good');
					$this->redirect(array('action' => 'my_account'));
				}
				//prd($this->User->validationErrors);
			}       
			$this->layout = 'home';
		}
		
	}
	?>