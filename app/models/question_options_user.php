<?php
class QuestionOptionsUser extends AppModel{

   var $name = "QuestionOptionsUser";
   var $belongsTo = array('QuestionOption','User');
	
	/* 
	* It return users that have same question's options as logined user
	*/
	function getUserList($auth_user_id = null){
		App::import('Model','User');
		$User = new User();
		/* ==========User Conditions=========== */
		$filters['user_cond'][] = array('User.access_permission'=>1,'User.status'=>1);
		$filters['user_list'] = $User->find('list',array('conditions'=>$filters['user_cond'],'fields'=>array('id','id')));
		 
		/* ==========questionOptionsUser Conditions=========== */
		//logined user question's options
		$loginedQuesOp = $this->find('list',array('conditions'=>array('user_id'=>$auth_user_id),'fields'=>array('id','question_option_id')));

		/* ========fetch questionOptionUserArr from questionOptionsUser model======= 
		* all options
		* 
		*/
		$this->unbindModel(array('belongsTo'=>array('QuestionOption','User')),false);
		$questionOptionUserArr = $this->find('all',array('conditions'=>array('user_id'=>$filters['user_list'])));
		/* =====set user_id=>array('optionsArr')======= */
		$userQuestions = array();		
		if(count($questionOptionUserArr)>0){
			foreach($questionOptionUserArr as $key=>$options){
				$user_id = $options['QuestionOptionsUser']['user_id'];				
				$userQuestions[$user_id]['question_option_id'][] = $options['QuestionOptionsUser']['question_option_id'];
			}		
		}
		/* =====filter user_id that have same questions at logined user======= */
		$getUsers = array();
		if(count($userQuestions) > 0){
			foreach($userQuestions as $user_id=>$quOpArr){
				if($this->twoArrayEqual($quOpArr['question_option_id'],$loginedQuesOp)){
					$getUsers[] = $user_id;
				}
			}
		}
		return $getUsers;
		
/* 		echo 'user list Arr::';
		pr($filters['user_list']);
		echo 'questionOptionUserArr::';
		pr($questionOptionUserArr);
		echo 'userQuestions::';
		pr($userQuestions);
		echo 'logined user options::';
		pr($loginedQuesOp);
		echo 'getUsers::';
		pr($getUsers);
		die; */	
	
	}
	/* $arr2 are question's options that selected by logined user */
	function twoArrayEqual($arr1 ,$arr2){
		foreach($arr2 as $key=>$value){
			if(!in_array($value,$arr1)){
				return false;
			}
		}
		return true;		
	}
   
 }
?>