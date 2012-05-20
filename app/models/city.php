<?php
class City extends AppModel{

	var $name = "City";
	/**
     * Behaviors used by the Model
     *
     * @var array
     * @access public
     */
    var $actsAs = array(        
        'Multivalidatable'
    );
	var $validationSets = array(	
		'admin'=>array(			
			'country_id' => array(								
	             'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Please Select Country Name.'
				  )
				),
				'state_id'=>array(
						'notEmpty'=>array(
						'rule'=>'notEmpty',
						'message' => 'Please Select State Name.'
					)
				),
				'name'=>array(
						'isUnique'=>array(
							'rule'	=>	array('uniqueCity', array('name')),
							'message'	=>	'Name is already exists.'	
						),
						'notEmpty'=>array(
							'rule'=>'notEmpty',
							'message' => 'Please Insert City Name.'
						)
					)
				
		));
	
	function getCityList($state_id = null){
		$data	=	$this->find('list', array('conditions' => array(
											'City.state_id' => $state_id, 
											'City.status'=>Configure::read('App.Status.active')
											),
											'order' => array('City.name'=>'ASC')
										)
								);
		return $data;
	}
	function getName($id = null){
		$data =  $this->read(null, $id);
		return $data['City']['name'];
	}
	function uniqueCity($data =null, $fieldName=null){
				$StateRec = $this->find('first',array(
								'fields'=>array('name'),
								'conditions'=>array(
									'City.country_id'=>$this->data['City']['country_id'],									 'City.state_id' =>$this->data['City']['state_id'],
									 'City.name' =>$this->data['City']['name'],
									)
								)
					);
				//pr($StateRec);
				if($StateRec){
					return false;
				}else{
					return true;
				}
	}		

	
   
}
?>