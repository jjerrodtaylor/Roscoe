<?php
/**
 * Country
 *
 * PHP version 5
 *
 * @category Model 
 * 
 */
class Country extends AppModel{
	/**
	 * Model name
	 *
	 * @var string
	 * @access public
	 */
	var $name = 'Country';
	
	/**
	 * Behaviors used by the Model
	 *
	 * @var array
	 * @access public
	 */
	 
	 
	 	
    var $actsAs = array(        
        'Multivalidatable'
    );
		var $hasMany=array(
			'State'=>array(
				'className'=>'State',
				'foriegnKey'=>'country_id',
				'dependent'=>true
			),
		);
	/**
     * Custom validation rulesets
     */	
	var $validationSets = array(
		'admin'	=>	array(		
			'name'=>array(
				'isUnique'	=>	array(
					'rule'	=>	'isUnique',
					'message'	=>	'Name is already exists.'
				),	
				/*'checkAlphaNumericDashUnderscore'	=> array(
					'rule'	=> 	array('checkAlphaNumericDashUnderscore', 'name'),
					'message' =>'Name should contain only letters, numbers, dashes and spaces.'
					
				),*/
				
				'notEmpty' => array(
					'rule' 		=> 'notEmpty',
					'message' 	=>	'Name is required'
				)
			)	,
			'iso_code'=>array(
				'iso_code'=>array(
					'rule'=>'notEmpty',
					'message' 	=>	'Iso Code  is required'
					
				)
			)
		)	
	);	
	
	function getCountryList(){
		$data = $this->find('list', array('conditions' => array('Country.status'=>Configure::read('App.Status.active'))));
		return $data;
	}
	
	function getName($id = null){
		$data =  $this->read(null, $id);
		return $data['Country']['name'];
	}

	function getCountryListData($countryid = 0)
		{
			if($countryid){
			
			$CountryRec = $this->find('first',array('fields'=>array('id', 'name'), 'conditions'=>array('Country.id' => $countryid,'Country.status'=>1)));
			}else{
			$CountryRec = $this->find('all',array('fields'=>array('id', 'name'), 'conditions'=>array('Country.status'=>1)));
			}
			return $CountryRec;
			
			
		}
	
	
	
	
}
?>