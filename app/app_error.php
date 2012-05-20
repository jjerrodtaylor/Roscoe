<?php
/**
 * AppError
 *
 * PHP version 5
 * 
 */
class AppError extends ErrorHandler
{

	/**
	* accessDenied
	*
	* @return void
	*/
	function accessDenied()
	{
		$this->controller->layout = "error";
		$name = array('name' => __('You are not authorized to perform this action', TRUE));
		$this->controller->set($name);
		$this->_outputMessage('denied');
		
	}
	/**
	* securityError
	*
	* @return void
	*/
    function securityError() {
        $this->controller->set(array(
            'referer' => $this->controller->referer(),
        ));
        $this->_outputMessage('security');
		
    }
}
?>