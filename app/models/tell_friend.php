<?php
/**
 * tell a friend
 *
 * PHP version 5
 *
 * @TellFriend Model 
 * 
 */
class TellFriend extends AppModel{
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'User';
	//var $useTable = false;
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
    var $actsAs = array(        
        'Multivalidatable'
    );
	var $hasOne=array(
			'TellFriendReference'=>array(
				'className'=>'UserReference',
				'foriegnKey'=>'user_id'				
			),
		);

	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
		'front'	=>	array(
				'to' =>array(
				'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message' => 'Email is required'
					),
					'email'=>array(
						'rule' => 'email',
						'message' => 'Email is Invalid'
					)					
				),
				'from' =>array(
					'notEmpty'=>array(
						'rule' => 'notEmpty',
						'message' => 'Email is required'
					),
					'email'=>array(
						'rule' => 'email',
						'message' => 'Email is Invalid'
					)					
				),
				'cc' =>array(
					'checkcc'=>array(
						'rule' => 'checkCc',
						'message' => 'Emails are Invalid.'
					)					
				),
				'bcc' =>array(
					'checkBcc'=>array(
						'rule' => 'checkBcc',
						'message' => 'Emails are Invalid.'
					)					
				),				
				'name'=>array(
					'rule'=>'notEmpty',
					'message'=>'Name is required.'
				),
				'subject'=>array(
					'rule'=>'notEmpty',
					'message'=>'Subject is required.'
				),
				'message'=>array(
					'rule'=>'notEmpty',
					'message'=>'Message is required.'
				)				
			)
		);
		function checkBcc($bcc){			
			if(!$bcc['bcc']){
				return true;
			}else{
				$bccArr = explode(',',$bcc['bcc']);
				//prd($bccArr);
				if(count($bccArr)>0){
					foreach($bccArr as $key=>$value){

						if(!Validation::email($value)){
							return false;
						}
					}				
				}elseif(!Validation::email($value)){					
					return false;										
				}

			}
			return true;
			//prd($this->data);
		}
		function checkCc($cc){			
			if(!$cc['cc']){
				return true;
			}else{
				$ccArr = explode(',',$cc['cc']);
				//prd($bccArr);
				if(count($ccArr)>0){
					foreach($bccArr as $key=>$value){

						if(!Validation::email($value)){
							return false;
						}
					}				
				}elseif(!Validation::email($value)){					
					return false;										
				}

			}
			return true;
			//prd($this->data);
		}		
}
?>