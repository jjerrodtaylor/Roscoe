<?php
class AmenityFixture extends CakeTestFixture {
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'text', 'null' => 'false'),
		'status' => array('type' => 'tinyint', 'null' => 'false'),
		'created' => array('type' => 'datetime', 'null' => 'false'),
		'modified' => array('type' => 'datetime', 'null' => 'false')
	);
	
	public function init(){	
		$this->records = array(
			array('id' => 1, 'name' => 'amenity fixture 1', 'status'=>'1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => 2, 'name' => 'amenity fixture 2', 'status'=>'0', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => 3, 'name' => 'amenity fixture 3', 'status'=>'1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => 4, 'name' => 'amenity fixture 4', 'status'=>'0', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => 5, 'name' => 'amenity fixture 5', 'status'=>'1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
		);
		parent::init();
	}
	
}