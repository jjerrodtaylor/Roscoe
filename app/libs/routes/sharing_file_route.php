<?php
class SharingFileRoute extends CakeRoute { 
    function parse($url) {
        $params = parent::parse($url);				
		
		if (empty($params)) {
            return false;
        }
		//pr($params);die(); 
	    App::import('Model', 'UploadFile');
		App::import('Component', 'Session');
		$session	= new SessionComponent();
		if($session->read('Auth.User.id'))
		{		
				$data = new UploadFile();
				
				$count = $data->find('count', array(
					'conditions' => array('UploadFile.randam_name LIKE ?' => $params['slug'] .'%'),
					'recursive' => -1
				));
		}else {
				App::import('Model', 'TempFile');
				$data = new TempFile();
				
				$count = $data->find('count', array(
					'conditions' => array('TempFile.randam_name LIKE ?' => $params['slug'] .'%'),
					'recursive' => -1
				));
		}
		
        if ($count) {		
		   return $params;
        }
		
        return false;
    }	
}
?>