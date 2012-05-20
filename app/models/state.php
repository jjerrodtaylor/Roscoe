<?php
/**
 * State
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class State extends AppModel{
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'State';
	
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
    var $actsAs = array(        
        'Multivalidatable'
    );

	var $belongsTo=array('Country');
	
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
		'admin'	=>	array(
			'country_id' =>array(
				'rule' => 'notEmpty',
				'message' => 'Country is required'
				),
			'name'=>array(
				'isUnique'	=>	array(
					'rule'	=>	array('uniqueState', array('name','country_id')),
					'message'	=>	'Name is already exists.'
				),
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Name is required'
				)
			),
/* 			'iso_code'=>array(
				'isUnique'	=>	array(
					'rule'	=>	array('uniqueState', array('name','country_id')),
					'message'	=>	'sate iso code is already exists.'
				),
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'sate iso code is already exists'
				)
			) */			
		)	
	);
	
	
	
	function getStateList($country_id = null){
		$data	=	$this->find('list', array('conditions' => array(
											'State.country_id' => $country_id, 
											'State.status'=>Configure::read('App.Status.active')
											),
											'order' => array('State.name'=>'ASC')
										)
								);
		return $data;
	}
	function getName($id = null){
		$data =  $this->read(null, $id);
		return $data['State']['name'];
	}
	
	function getStateListData($state_id = 0)
	{
			$StateRec = $this->find('first',array('fields'=>array('id', 'name'), 'conditions'=>array('State.country_id 	' => $state_id,'State.status'=>1)));
			return $StateRec;
	}
	
	function getStateListName($state_id = 0)
	{
								
								$StateRecord = $this->find('list',array('fields'=>array('id', 'name'),'conditions'=>array(
								'State.id' => $state_id,'State.status'=>1)));
								return $StateRecord;
			//echo $StateRecord;
	}
	function getallStateListName($state_id)
	{
								
								$StateRecord = $this->find('all',array('fields'=>array('id', 'name'),'conditions'=>array(
								'State.id' => $state_id,'State.status'=>1)));
								
								return $StateRecord;
			//echo $StateRecord;
	}
		
	function uniqueState($data =null, $fieldName=null){
			
				$StateRec = $this->find('first',array(
								'fields'=>array('id', 'name'),
								'conditions'=>array(
									'State.country_id'=>$this->data['State']['country_id'],										'State.name' =>$this->data['State']['name']
									)
								)
					);
				if($StateRec){
					return false;
				}else{
					return true;
				}
	}		
}
?>