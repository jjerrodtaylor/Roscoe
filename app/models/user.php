<?php
class User extends AppModel 
{
	var $name = 'User';
	 /**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    var $actsAs = array(        
        'Multivalidatable'
    );	
	//var $belongsTo=array('SellItem');
	var $hasOne=array(
			'UserReference'=>array(
				'className'=>'UserReference',
				'foriegnKey'=>'user_id',
				'dependent'=>true
			),
		);
	var $hasMany=array(
			'UserImage'=>array(
				'className'=>'UserImage',
				'foriegnKey'=>'user_id',
				'dependent'=>true
			),
		);
/* 	var $hasAndBelongsToMany = array(
			'QuestionOption' =>
				array(
					 'className'              => 'QuestionOption',
					 'joinTable'              => 'question_options_users',
					 'foreignKey'             => 'user_id',
					 'associationForeignKey'  => 'question_option_id',
					 
					 
				)
		); */		
	
	/**
	
     * Custom validation rulesets
     */	
	var $validationSets = array(
		'admin'	=>	array(
			'password2'	=> array(
				'minlength' => array(
					'rule'	=> 	array('minLength', 6),
					'message'	=>	'Password should be atleast 6 characters long.'	
				),
				'notEmpty'	=> array(
					'rule'	=> 	'notEmpty',
					'message'	=>	'Password is required'
				)
			),
			'username'=>array(
				'rule'	=> 	'notEmpty',
				'message'	=>	'Username is required'			
			),
			'email'=>array(
				'isUnique'	=>	array(
					'rule'	=>	array('checkEmail','email'),
					'message'	=>	'Email already exists.'
				),
				'email'	=>	array(
					'rule'	=>	'email',
					'message'	=>	'Please provide a valid email address.'
				),				
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Email is required'
				)
			),
			'confirm_password'=>array(
				  'identicalFieldValues' => array(
							'rule' => array('identicalFieldValues', 'password2' ),
							'message' => 'Do not match confirm password please re enter password.'
						),
				 'R1'=>array(
						   'rule'=>'notEmpty',
						   'message' => 'Confirm password is required.'
					 )				   
			),
		),
		'front'	=>	array(
			'password2'	=> array(
				'minlength' => array(
					'rule'	=> 	array('minLength', 6),
					'message'	=>	'Password should be atleast 6 characters long.'	
				),
				'notEmpty'	=> array(
					'rule'	=> 	'notEmpty',
					'message'	=>	'Password is required'
				)
			),
			'email'=>array(
				'isUnique'	=>	array(
					'rule'	=>	array('checkEmail','email'),
					'message'	=>	'Email already exists.'
				),
				'email'	=>	array(
					'rule'	=>	'email',
					'message'	=>	'Please provide a valid email address.'
				),				
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Email is required'
				)
			),
			'confirm_password'=>array(
				  'identicalFieldValues' => array(
							'rule' => array('identicalFieldValues', 'password2' ),
							'message' => 'Do not match confirm password please re enter password.'
						),
				 'R1'=>array(
						   'rule'=>'notEmpty',
						   'message' => 'Confirm password is required.'
					 )				   
			)
			
		),		
		'change_password'=>array(
			'password2'	=> array(
				'minlength' => array(
					'rule'	=> 	array('minLength', 6),
					'message'	=>	'Password should be atleast 6 characters long.'	
				),
				'notEmpty'	=> array(
					'rule'	=> 	'notEmpty',
					'message'	=>	'Password is required'
				)
			),
			'confirm_password'=>array(
				  'identicalFieldValues' => array(
							'rule' => array('identicalFieldValues', 'password2' ),
							'message' => 'Do not match confirm password please re enter password.'
						),
				 'R1'=>array(
						   'rule'=>'notEmpty',
						   'message' => 'Confirm password is required.'
					 )				   
			 )
		),
		'forget_password'=>array(
			'email'	=> array(
				'email' => array(
					'rule'	=> 	'email',
					'message'	=>	'Email is invalid.'	
				),
				'notEmpty'	=> array(
					'rule'	=> 	'notEmpty',
					'message'	=>	'Email is required'
				)
			)

		)		
	);	
	function checkEmail($data = null, $field=null)
	{
		
		if(!empty($field)){
			if(!empty($this->data[$this->name][$field])){				
				if(isset($this->data['User']['id'])){
					$condition = $this->hasAny(array('User.id !='=>$this->data['User']['id'],'User.email' => $this->data[$this->name][$field],'User.role_id'=>$this->data[$this->name]['role_id']));
				}else{
					$condition = $this->hasAny(array('User.email' => $this->data[$this->name][$field],'User.role_id'=>$this->data[$this->name]['role_id']));
				}
				if($condition){
					return false;
				}else{
					return true;
				}
			}
		}
	}
	/*  */
	function identicalFieldValues( $field=array(), $compare_field=null ) 
	{
		
		foreach( $field as $key => $value ){
			$v1 = $value;
			$v2 = $this->data[$this->name][$compare_field ];  

			if($v1 !== $v2) {
				return false;
			} else {
				continue;
			}
		}
		return true;
	}
	function identicalEmail( $field=array(), $compare_field=null ) 
	{

		foreach( $field as $key => $value ){
			$v1 = $value;
			$v2 = $this->data[$this->name][$compare_field ];  

			if($v1 !== $v2) {
				return false;
			} else {
				continue;
			}
		}
		return true;
	}
	function checkOldPassword( $field = array(), $password = null ) 
	{
		App::import('Component', 'Session');
		$Session = new SessionComponent();
		$userId = $Session->read('Auth.User.id');//User or Admin or 
		$count	=	$this->find('count',array('conditions'=>array(
				'User.password'=>Security::hash($this->data[$this->name][$password], null, true),
				'User.id'=>$userId
			)));
		if($count == 1){
			return true;
		}else{
			return false;
		}
	}
}
?>