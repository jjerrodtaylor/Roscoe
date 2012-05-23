<?php
class CountryFixture extends CakeTestFixture {
	public $fields = array(
		'id' => array('type' => 'integer', 'key' => 'primary'),
		'name' => array('type' => 'varchar', 'length' => '255', 'null' => 'false'),
		'iso_code' => array('type' => 'varchar', 'length' => '32', 'null' => 'true'),
		'status' => array('type' => 'tinyint', 'length' => '4', 'null' => 'false'),
		'created' => array('type' => 'datetime', 'null' => 'false'),
		'modified' => array('type' => 'datetime', 'null' => 'false')
	);
	
	public function init(){
		
		$this->records = array(
			array('id' => '1', 'name' => 'Country 1', 'iso_code' => '12345', 'status' => '1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => '2', 'name' => 'Country 2', 'iso_code' => '12345', 'status' => '0', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => '3', 'name' => 'Country 3', 'iso_code' => '12345', 'status' => '1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => '4', 'name' => 'Country 4', 'iso_code' => '12345', 'status' => '0', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
			array('id' => '5', 'name' => 'Country 5', 'iso_code' => '12345', 'status' => '1', 'created' => date('Y-m-d H:i:s'), 'modified' => date('Y-m-d H:i:s')),
		);
	}
}
	