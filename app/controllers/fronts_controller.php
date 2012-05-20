<?php
/**
 * Cities Controller
 *
 * PHP version 5
 *
 * @category Controller
 */
class FrontsController extends AppController{
	/**
     * Controller name
     *
     * @var string
     * @access public
     */
	var $name	=	'Fronts';
	/**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */	 
	var $uses =array();
  var $helpers = array('General','Form','Ajax','Javascript','Html','Image');
	var $components = array("Session", "Email","Auth","RequestHandler");
   /**
	 * beforeFilter
	 * @return void
	 */	 
	function beforeFilter(){
		parent::beforeFilter();	 
		$this->Auth->allow('index');
		if (in_array($this->params['action'], array('admin_process'))){
			$this->Security->validatePost = false;						
		}
	}
	/*
	* Front page 
	*/
	function index() {
		$this->set("title_for_layout","Welcome to iwantaroommate");
		
	}
	
					
}
?>