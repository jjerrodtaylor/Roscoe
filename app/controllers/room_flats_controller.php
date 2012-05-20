<?php
App::import('Sanitize');
class RoomFlatsController extends AppController {

	var $name = 'RoomFlats';	
	
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	var $helpers = array('General','Form','Ajax','javascript','Paginator');
	var $components = array("Session", "Email","Auth","RequestHandler");

	var $uses	=	array('RoomFlat','User','Country','State','RoomFlatType','Amenity');
	
	var $model = 'RoomFlat';
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
	function admin_index(){
		$modelName = $this->_getModelName();
		$filters = array();		
		if(!isset($this->params['named']['page'])){
			$this->Session->delete('UserSearch');
		}
		if(!empty($this->data)){
			$this->Session->delete('UserSearch');
			if(!empty($this->data['User']['email'])){
				$keyword = Sanitize::escape($this->data['User']['email']);
				$this->Session->write('UserSearch', $keyword);				
			}				
		}

		if($this->Session->check('UserSearch')){		
			$filters[] = array('User.email LIKE'=>"%".$this->Session->read('UserSearch')."%");					
		}
		$this->paginate[$modelName] = array(
								'limit'=>Configure::read('App.AdminPageLimit'), 
								'order'=>array($modelName.'.id'=>'DESC'),
								'conditions'=>$filters
								);

		$data = $this->paginate($modelName);  
		$this->set(compact('data','modelName'));	 
		$this->set('title_for_layout',  __($modelName, true));	
		//pr($data);die;
	}
	function admin_add(){
		$modelName = $this->_getModelName();		
		$this->set('title_for_layout', __('Add New Room/Flat', true));
		if(!empty($this->data)) {
			//prd($this->data);
			$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);			
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('admin');
			if($this->$modelName->validates()){
				$this->$modelName->create();			
				if ($this->$modelName->saveAll($this->data)) {				 
					$this->Session->setFlash('Record added successfully.','admin_flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happend.Please again try.','admin_flash_bad');
				
				}
			}else{
				$this->Session->setFlash('Please remove below errors.','admin_flash_bad');
			
			}
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
			$this->set(compact('states'));				
			$hash = $this->data['RoomFlat']['room_flat_number'];
		}else{
			$hash = $this->_randomPrefix(20);	
		}
		
		$amenities = $this->Amenity->find('list',array('Amenity.status'=>1));
		$roomType = $this->RoomFlatType->find('list',array('conditions'=>array('RoomFlatType.status'=>1)));
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
		$userList = $this->User->find('list', array('conditions'=>array('User.status'=>1,'User.role_id'=>2),'fields' => array('User.email')));

		$this->set(compact('modelName','hash','userList','countries','roomType','amenities'));
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
			
			$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);
		
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
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
			
		
		}else{
			$this->data = $this->$modelName->read(null,$id);
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
							
		}
		
		
		$amenities = $this->Amenity->find('list',array('Amenity.status'=>1));
		$roomType = $this->RoomFlatType->find('list',array('conditions'=>array('RoomFlatType.status'=>1)));
		$rand =  $this->data[$modelName]['room_flat_number'];	
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
		$userList = $this->User->find('list', array('conditions'=>array('User.status'=>1,'User.role_id'=>2),'fields' => array('User.email')));

		$this->set(compact('modelName','rand','userList','countries','states','roomType','amenities'));
		
		
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
	/* =============================Add images===================================== */
	function admin_addimage($room_flat_id = null){
		if(!$room_flat_id){			
			$this->Session->setFlash('Invalid Id','admin_flash_good');
			$thsi->redirect(array('action'=>'index'));
		}else{
		
			if(!empty($this->data)){
				$this->loadModel('RoomFlatImage');
				//prd($this->data);
				$data = $this->RoomFlatImage->setRoomFlatId($this->data['RoomFlatImage'],$room_flat_id);
				if($this->RoomFlatImage->saveAll($data)){
					$this->Session->setFlash('Images saved successfully.','admin_flash_good');
					$this->redirect(array('action'=>'index'));						
				}else{
					$this->Session->setFlash('Not found images for saving.','admin_flash_good');
					$thsi->redirect(array('action'=>'index'));					
				}
				
				
			}else{
				
				$this->loadModel('RoomFlatImage');
				$this->RoomFlatImage->unbindModel(array('belongsTo'=>array('RoomFlat')),false);
				$roomFlatImageArr = $this->RoomFlatImage->find('all',array('RoomFlatImage.room_flat_id'=>$room_flat_id));
				if(count($roomFlatImageArr) >0){
					$hash = $roomFlatImageArr[0]['RoomFlatImage']['hash'];
				}else{					
					$hash = $this->_randomPrefix(20);
				}
				//prd($hash);die;
				$this->set(compact('roomFlatImageArr','hash','room_flat_id'));
			}
			
		}		
	
	}	
	/* get state at change country */
	function state(){
	
		if($this->RequestHandler->isAjax()){
			Configure::write('debug',0);
			$country_id = $_REQUEST['country_id'];
			$action = $_REQUEST['action'];
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$country_id)));
			$this->set(compact('states','action'));
			$view = $this->render('/elements/room_flats/state');
			$this->layout ='';
			$this->render(false);
			echo json_encode(array('value'=>$view));
			exit();	
		}
	}
	/* =======================image show both in admin and front after deleting====================================== */
	function view_image(){
		Configure::write('debug',0);
		if($this->RequestHandler->isAjax()){
			$this->loadModel('RoomFlatImage');
			$id = $_REQUEST['id'];
			
			$this->RoomFlatImage->unbindModel(array('belongsTo'=>array('RoomFlat')),false);
			$data = $this->RoomFlatImage->read(null,$id);				
			/* delete record from table */
			$this->RoomFlatImage->delete(array('RoomFlatImage.id'=>$id));				
			
			/* delete image form image folder */
			$this->RoomFlatImage->deleteImages($data);	
			
			$this->layout ='';
			$this->render(false);
			echo json_encode(array('value'=>'1'));
			exit();		
		
		}
	
	}
	/* =======Add room/flat from front=========== */
	function add(){
		$modelName = $this->_getModelName();		
		$this->set('title_for_layout', __('Add New Room/Flat', true));
		if(!empty($this->data)) {
			
			$this->data[$modelName]['user_id'] = $this->Auth->user('id');
			$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);			
			
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('admin');
			if($this->$modelName->validates()){
				$this->$modelName->create();			
				if ($this->$modelName->saveAll($this->data)) {				 
					$this->Session->setFlash('Record added successfully.','flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happend.Please again try.','flash_bad');
				
				}
			}else{
				$this->Session->setFlash('Please remove below errors.','admin_flash_bad');
			
			}
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
			$this->set(compact('states'));				
			$hash = $this->data['RoomFlat']['room_flat_number'];
		}else{
			$hash = $this->_randomPrefix(20);	
		}
		
		$amenities = $this->Amenity->find('list',array('Amenity.status'=>1));
		$roomType = $this->RoomFlatType->find('list',array('conditions'=>array('RoomFlatType.status'=>1)));
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
		$this->set(compact('modelName','hash','countries','roomType','amenities'));
		$this->layout = 'home';
	}
	/* ======show room/flat list==== */
	function index(){
		$modelName = $this->_getModelName();		
		$this->set('title_for_layout', __('List Room/Flat', true));	
		$this->paginate[$modelName] = array(
										'limit'=>Configure::read('App.PageLimit'),
										'order'=>'RoomFlat.id DESC',
										'conditions'=>array('RoomFlat.user_id'=>$this->Auth->user('id'))
										);
		$data = $this->paginate($modelName);		
		$this->set(compact('data'));
		//ajax paginations
        if($this->RequestHandler->isAjax()) {
			Configure::write('debug',0);
            $this->viewPath = 'elements'.DS.'room_flats';
            $this->render('list_room_flat');            
        } 		
		$this->layout = 'home';
	}
	/* ==========more detail from room/flat list, search and advanced search========== */
	function more_detail($id = null){
		$modelName = $this->_getModelName();
		$this->$modelName->Country->unbindModel(array('hasMany'=>array('State')),false);
		$this->$modelName->State->unbindModel(array('belongsTo'=>array('Country')),false);
		$this->$modelName->RoomFlatImage->unbindModel(array('belongsTo'=>array('RoomFlat')),false);
		$this->$modelName->RoomFlatType->unbindModel(array('hasOne'=>array('RoomFlat')),false);
		
		if(!$id){
			$this->Session->setFlash('Invalid Id','flash_bad');
			$this->redirect(array('action'=>'index'));
		}
 		$this->$modelName->recursive = 2;
	/*	$this->$modelName->Behaviors->attach('Containable');

		$this->$modelName->contain(array(
					'RoomFlatType'=>array('name'),
					'Country'=>array('name','iso_code'),
					'State'=>array('name'),
					'User'=>array(
						'UserReference'						
						),
					'RoomFlatImage',
					'Amenity'
				));	 */	
		$data = $this->$modelName->find('first',array('conditions'=>array($modelName.'.id'=>$id)));
		$prevAction = $this->params['named']['preaction'];
		$this->set(compact('data','prevAction'));
		$this->layout = 'home';
		//prd($data);
	}
	/* =======edit room/flat form front page========= */
	function edit($id = null){
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));

		$this->set('title_for_layout', __('Edit Room/Flat', true));
		if(!empty($this->data)) {
			$this->data[$modelName]['user_id'] = $this->Auth->user('id');
			$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);
			
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('admin');
			if ($this->$modelName->validates()){
				$this->$modelName->create();			
				if ($this->$modelName->save($this->data)) {				 
					$this->Session->setFlash('Record updated successfully.','flash_good');
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('Any error happened.Please again try.','flash_bad');				
				}
			}else{
				$this->Session->setFlash('Please remove below errors.','flash_bad');				
			}
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
			
		
		}else{
			$this->data = $this->$modelName->find('first',array('conditions'=>array($modelName.'.id'=>$id,$modelName.'.user_id'=>$this->Auth->user('id'))));
			if(count($this->data) <= 0){
				$this->Session->setFlash('Invalid id','admin_flash_bad');
				$this->redirect(array('action' => 'index'));			
			}
			$states = $this->State->find('list',array('conditions'=>array('State.status'=>1,'State.country_id'=>$this->data['RoomFlat']['country_id'])));
							
		}
		
		
		$amenities = $this->Amenity->find('list',array('Amenity.status'=>1));
		$roomType = $this->RoomFlatType->find('list',array('conditions'=>array('RoomFlatType.status'=>1)));
		$rand =  $this->data[$modelName]['room_flat_number'];	
		$countries = $this->Country->find('list',array('conditions'=>array('Country.status'=>1)));
		$userList = $this->User->find('list', array('conditions'=>array('User.status'=>1,'User.role_id'=>2),'fields' => array('User.email')));
		$this->set(compact('modelName','rand','userList','countries','states','roomType','amenities'));
		$this->layout = 'home';
		
	}
	/* ======delete room/flat with images========= */
	function delete($id = null) {
		$modelName = $this->_getModelName();
		$this->set(compact('modelName'));	

		if(!$id){
			$this->Session->setFlash('Invalid Id', 'flash_bad');
			$this->redirect(array('action' => 'index'));
		}
	
		$data = $this->$modelName->RoomFlatImage->find('first',array('conditions'=>array('RoomFlatImage.room_flat_id'=>$id),'fields'=>'hash'));

		if($this->$modelName->deleteAll(array($modelName.'.id'=>$id,$modelName.'.user_id'=>$this->Auth->user('id')),true)) {	 
			if(count($data)>0){
				$this->$modelName->RoomFlatImage->deleteAll(array('RoomFlatImage.room_flat_id'=>$id,'RoomFlatImage.hash'=>$data['RoomFlatImage']['hash']),true);
				$this->General->deleteDirectory(WWW_ROOT.'img'.DS.IMAGE_ROOM_FLAT_FOLDER_NAME.DS.$data['RoomFlatImage']['hash']);
			}
			$this->Session->setFlash('Record Deleted successfully.', 'flash_good');
			$this->redirect(array('action'=>'index'));		
		}
		$this->Session->setFlash('Any error happened.Please again try.', 'flash_bad');
		$this->redirect(array('action' => 'index'));
	}
	/* =============================Add images from front===================================== */
	function addimage($room_flat_id = null){
		$modelName = $this->_getModelName();
		$checkCount = $this->$modelName->find('count',array('conditions'=>array($modelName.'.id'=>$room_flat_id,$modelName.'.user_id'=>$this->Auth->user('id'))));
		//pr($checkCount);die;
		if(!$room_flat_id || !$checkCount){			
			$this->Session->setFlash('Invalid Id','flash_good');
			$thsi->redirect(array('action'=>'index'));
		}else{
		
			if(!empty($this->data)){
				$this->loadModel('RoomFlatImage');
				//prd($this->data);
				$data = $this->RoomFlatImage->setRoomFlatId($this->data['RoomFlatImage'],$room_flat_id);
				if($this->RoomFlatImage->saveAll($data)){
					$this->Session->setFlash('Images saved successfully.','flash_good');
					$this->redirect(array('action'=>'index'));						
				}else{
					$this->Session->setFlash('Not found images for saving.','flash_good');
					$thsi->redirect(array('action'=>'index'));					
				}
				
				
			}else{
				
				$this->loadModel('RoomFlatImage');
				$this->RoomFlatImage->unbindModel(array('belongsTo'=>array('RoomFlat')),false);
				
				$roomFlatImageArr = $this->RoomFlatImage->find('all',array('RoomFlatImage.room_flat_id'=>$room_flat_id));
				if(count($roomFlatImageArr) >0){
					$hash = $roomFlatImageArr[0]['RoomFlatImage']['hash'];
				}else{					
					$hash = $this->_randomPrefix(20);
				}
				//prd($hash);die;
				$this->set(compact('roomFlatImageArr','hash','room_flat_id'));
			}
			
		}		
	
	}
	/* ================================================================ */
	/* ======================Normal Search room/flat==================== */
	/* ================================================================ */
	function search(){
		
		$modelName = $this->_getModelName();		
		if(!isset($this->params['named']['page']) && !$this->RequestHandler->isAjax()){
			if($this->Session->check('Search')){
				$this->Session->delete('Search');					
			}		
		}elseif(isset($this->params['named']['page'])){
			$this->set('page',$this->params['named']['page']);
		}
		$filters[] = array($modelName.'.booked'=>0,$modelName.'.status'=>1,'User.access_permission'=>1,'User.status'=>1);
		if(isset($this->data[$modelName]['keyword']) && !empty($this->data[$modelName]['keyword'])){			
			if($this->data[$modelName]['keyword'] !='Please Enter your keyword here'){
				$filters['OR'] = $this->_getConditons($this->data[$modelName]['keyword']);
			}			
			$this->Session->write('Search.keyword',$this->data[$modelName]['keyword']);
			//get sameoption's users as logined user
			$this->loadModel('QuestionOptionsUser');
			$sameOptionsUsers = $this->QuestionOptionsUser->getUserList($this->Auth->user('id'));	
			$filters[] = array($modelName.'.user_id'=>$sameOptionsUsers);		
			$this->Session->write('Search.cond',$filters);
		}
		
		if(!$this->Session->check('Search')){
			$this->Session->write('Search.keyword','Please Enter your keyword here');
			//get sameoption's users as logined user
			$this->loadModel('QuestionOptionsUser');
			$sameOptionsUsers = $this->QuestionOptionsUser->getUserList($this->Auth->user('id'));	
			$filters[] = array($modelName.'.user_id'=>$sameOptionsUsers);		
			$this->Session->write('Search.cond',$filters);		
			$this->Session->write('Search.cond',$filters);		
		}	
		//pr($this->Session->read('Search.cond'));
		//pr($this->data);
		//die;
		$this->_fetchSearchData();
	}
	function _fetchSearchData(){
		$modelName = $this->_getModelName();
		/* ===============Set order================= */		
        if($this->RequestHandler->isAjax()){
			if(isset($_REQUEST['sort_price'])){
				$sort_key = $_REQUEST['sort_price'];
				$this->Session->write('Search.sort_key',$sort_key);	
			}          
        }
		if($this->Session->check('Search.sort_key')){			
 			$sort_key = $this->Session->read('Search.sort_key');
			$this->data[$modelName]['sort_price'] = $sort_key;
			if($sort_key ==1){
				$order[$modelName.".id"] = 'DESC';
			}elseif($sort_key ==2){
				$order[$modelName.".id"] = 'ASC';
			}elseif($sort_key ==3){
				$order[$modelName.".price"] = 'DESC';
			}elseif($sort_key ==4){
				$order[$modelName.".price"] = 'ASC';
			}else{
				$order[$modelName.".id"] = 'ASC';
			}			
		}else{
			$order[$modelName.".id"] = 'ASC';
		}
		//prd($$this->Session->read('Search.cond'));
		/* =========End of set order============= */
		$this->paginate[$modelName] = array(
						'limit'=>Configure::read('App.PageLimit'),
						'order'=>$order,
						'conditions'=>$this->Session->read('Search.cond')
					);
		$data = $this->paginate($modelName);
		$this->set(compact('data'));
		//ajax paginations
        if($this->RequestHandler->isAjax()) {
			Configure::write('debug',0);
            $this->viewPath = 'elements'.DS.'room_flats';
            $this->render('search_result');            
        }
		//prd($data);
		$this->layout = 'home';		
	}
	/* ================================================================ */
	/* =======Set conditions for normal Search room/flat================ */
	/* ================================================================ */	
	function _getConditons($keyword = null){
		
		$cond = null;
		$keyword = trim($keyword);
		$keyword = preg_replace('/\s+/', ' ',$keyword);
		if($keyword){
			/* set other model and fields with keyword value*/
			$op = array('RoomFlat'=>array('city_name','zipcode','total_room','total_bathroom','description','price'));
			$arrayOp[] = $this->_keyConditions($keyword,$op);
			
			/* split from comma */
			$commaKeyArr = explode(',',$keyword);
			
			if(count($commaKeyArr)>1){
				foreach($commaKeyArr as $key=>$value){
					$arrayOp[] = $this->_keyConditions($value,$op);			
				}			
			}
			/* end here */
			
			/* split from space */
			$spaceKeyArr = explode(' ',$keyword);
			/* end here */
			if(count($spaceKeyArr)>1){
				foreach($spaceKeyArr as $key=>$value){
					$arrayOp[] = $this->_keyConditions($value,$op);			
				}			
			}			
			
			/* set conditions */
			if(is_array($arrayOp)){
				foreach($arrayOp as $index=>$value){
					$cond[] = $this->postConditions($value,'like','OR');
				}				
			}else{
				$cond = $this->postConditions($arrayOp,'like','OR');		
			}			
			
		}
		return $cond ;
	}
	/* ============Advance search form============ */
	function add_search(){
		$modelName = $this->_getModelName();
		$this->set('title_for_layout','Advance Search');
		if(!empty($this->data)){
			$this->$modelName->set($this->data);
			$this->$modelName->setValidation('advanced_search');
			
			if($this->$modelName->validates($this->data)){
				/* set session for searching */
				if($this->Session->check('Search')){
					$this->Session->delete('Search');					
				}	
				$this->data[$modelName] = $this->General->myclean($this->data[$modelName]);		
				$filters[] = array($modelName.'.booked'=>0,$modelName.'.status'=>1);		
				
				if($this->data[$modelName]['total_bathroom']){
					$filter[] = array(
						$modelName.'.room_flat_type_id'=>$this->data[$modelName]['room_type'],
						$modelName.'.total_room'=>$this->data[$modelName]['total_room'],
						$modelName.'.total_bathroom'=>$this->data[$modelName]['total_bathroom'],
						$modelName.'.price >='=>$this->data[$modelName]['minrent'],
						$modelName.'.price <='=>$this->data[$modelName]['maxrent']
					);		
				}else{
					$filter[] = array(
						$modelName.'.room_flat_type_id'=>$this->data[$modelName]['room_type'],
						$modelName.'.total_room'=>$this->data[$modelName]['total_room'],						
						$modelName.'.price >='=>$this->data[$modelName]['minrent'],
						$modelName.'.price <='=>$this->data[$modelName]['maxrent']
					);	
				}
			
				//get sameoption's users as logined user
				$this->loadModel('QuestionOptionsUser');
				$sameOptionsUsers = $this->QuestionOptionsUser->getUserList($this->Auth->user('id'));	
				$filter[] = array($modelName.'.user_id'=>$sameOptionsUsers);
				
				$this->Session->write('Search.cond',$filter);
				$this->redirect(array('action'=>'advance_search_result'));
				/* end here */
				
			}

		}
		$roomType = $this->RoomFlatType->find('list',array('conditions'=>array('RoomFlatType.status'=>1)));
		$this->set(compact('roomType'));		
		$this->layout = 'home';
		
	}
	/* ======advance search result and pagination operation======= */
	function advance_search_result(){
		$this->_fetchSearchData();
	}
	/* ================Google map for room/flat area======================= */
	function view_room_flat_areas($id=null)
	{
		$modelName = $this->_getModelName();
		$this->$modelName->unbindModel(array('belongsTo'=>array('User','RoomFlatType'),'hasAndBelongsToMany'=>array('Amenity'),'hasMany'=>array('RoomFlatImage')),false);
		$roomFlatAreas = $this->$modelName->find('first', array('conditions' => array($modelName.'.id' => $id )));
		$this->set('modelName',$modelName);
		$this->set(compact('roomFlatAreas',$modelName));		
		//prd($roomFlatAreas);
		$this->layout = false;
	}

}
?>
