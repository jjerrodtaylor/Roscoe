<?php
/**
 * Application controller
 *
 * This file is the base controller of all other controllers
 *
 * PHP version 5
 *ksansi
abhilash123
 * @category Controllers
 * @package  Training
 * @version  1.0 
 */
class AppController extends Controller {

    /**
     * Components
     *
     * @var array
     * @access public
     */    
    var $components = array(    
        'Security',          
        'Auth',  
		'Session',	
        'RequestHandler',       
        'Email',
        'General',
        'Breadcrumb',
		'Cookie',		
    );
    
    /**
     * Helpers
     *
     * @var array
     * @access public
     */
    var $helpers = array(
        'Html',
        'Form',
        'Text',
        'Javascript',
        'Time',
        'Layout',
		'General',
		'Ajax',
		'ExPaginator',
		'fck',
		'Admin',
		'Thickbox'
    );
    /**
     * Models
     *
     * @var array
     * @access public
     */
    var $uses = array();
    /**
     * Cache pagination results
     *
     * @var boolean
     * @access public
     */
    //var $usePaginationCache = true;
    /**
     * View
     *
     * @var string
     * @access public
     */
   // var $view = 'Theme';
    /**
     * Theme
     *
     * @var string
     * @access public
     */
  //  var $theme;
    /**
     * Set Pagination setting
     * */
//   var $paginate = array('limit'=>'4');

    /**
     * beforeFilter
     *
     * @return void
     */
    function beforeFilter() {
	
		$this->Security->blackHoleCallback = '__securityError'; 	
		$this->disableCache();
			if(isset($this->params['admin'])) {
				$this->layout = 'admin';             	     
				$this->Auth->userModel = 'User';
				$this->Auth->userScope = array('User.status' =>1,'User.role_id'=>1);
				$this->Auth->loginError = "Login failed. Invalid Email Address or password";
				$this->Auth->fields = array('username'=>'email', 'password'=>'password');
				$this->Auth->loginAction = array('admin' => true, 'controller' => 'users', 'action' => 'login');
				$this->Auth->loginRedirect = array('admin' => true, 'controller' => 'users', 'action' => 'dashboard');
				$this->Auth->authError = 'You must login to view this information.';
				$this->Auth->authorize 		= 'controller';
				$this->Auth->autoRedirect = true;
				//$this->Auth->allow('login'); 		
			}else{
				//pr($this->data);die;
				$this->Auth->userModel 		=	'User';
				$this->Auth->userScope 		= 	array('User.status' =>1,'User.role_id'=>2);
				$this->Auth->loginError 	=	"Login failed. Invalid Email Address or password";
				$this->Auth->loginAction 	=   array('controller' => 'registers', 'action' => 'login');
				$this->Auth->fields			=	array('username' => 'email', 'password' => 'password');	
				$this->Auth->loginRedirect 	=	array('admin'=>false,'controller' => 'registers', 'action' => 'my_account');	
				$this->Auth->logoutRedirect = array('controller'=>'registers','action'=>'login');
				$this->Auth->authorize 		= 'controller';				
				$this->Auth->autoRedirect 	= 	true;				
				//$this->Auth->allowedActions	= 	array('logout', 'login','signup');
							
			}
			$this->loadModel('Setting');
			$this->Setting->getSetting();				
			$this->isAuthorized();

			
    }   
	function isAuthorized() {
		 if(isset($this->params['admin'])) {
			 if($this->Auth->user()){
				if($this->Auth->user('role_id') != 1){
				   $this->cakeError('accessDenied');					
			   }
			}
		 }
        return true;
    }
	 function __securityError() {
        //$this->cakeError('securityError');
    }
	function beforeRender() { 
		
		
	} 
		/**
     * undocumented function
     *
     * @param string $model
     * @return void
     * @access public
     */
	function pageForPagination($model) {
			$page = 1;
			$sameModel = isset($this->params['named']['model']) && $this->params['named']['model'] == $model;
			$pageInUrl = isset($this->params['named']['page']);
			if ($sameModel && $pageInUrl) {
					$page = $this->params['named']['page'];
			}
		 
			$this->passedArgs['page'] = $page;
			
			return $page;
	}
	function __sendMail($To, $Subject, $message, $From,$template, $smtp="0") {
         
			$this->Email->to      = $To;
			$this->Email->from    = "cellsolo.com<".$From.">";
			$this->Email->subject = $Subject;           
			$this->Email->sendAs = 'both';			
			$this->Email->template = $template;
			$this->Email->layout = 'default';			
			if($smtp == 1)
			{
					$this->Email->smtpOptions = array(
					'port' => '25',
					'timeout' => '30',
					'host' => 'relay.airtelbroadband.in',
					'username' => 'test@octalsoftware.com',
					'password' => 'octal123',
					'client' => 'smtp_helo_hostname'
					);
					$this->Email->delivery = 'smtp';
			}           
			$this->set('message',$message);
			if($this->Email->send($message))
			{
					return true;
			}
			else
			{
					return false;
			}
		}
		function displaySqlDump(){
		 if (!class_exists('ConnectionManager') || Configure::read('debug') < 2) {
				return false;
			}
			$noLogs = !isset($logs);
			if ($noLogs):
				$sources = ConnectionManager::sourceList();

				$logs = array();
				foreach ($sources as $source):
					$db =& ConnectionManager::getDataSource($source);
					if (!$db->isInterfaceSupported('getLog')):
						continue;
					endif;
					$logs[$source] = $db->getLog();
				endforeach;
			endif;

			if ($noLogs || isset($_forced_from_dbo_)):
				foreach ($logs as $source => $logInfo):
					$text = $logInfo['count'] > 1 ? 'queries' : 'query';
					printf(
						'<table class="cake-sql-log" id="cakeSqlLog_%s" summary="Cake SQL Log" cellspacing="0" border = "0">',
						preg_replace('/[^A-Za-z0-9_]/', '_', uniqid(time(), true))
					);
					printf('<caption>(%s) %s %s took %s ms</caption>', $source, $logInfo['count'], $text, $logInfo['time']);
				?>
				<thead>
					<tr><th>Nr</th><th>Query</th><th>Error</th><th>Affected</th><th>Num. rows</th><th>Took (ms)</th></tr>
				</thead>
				<tbody>
				<?php
					foreach ($logInfo['log'] as $k => $i) :
						echo "<tr><td>" . ($k + 1) . "</td><td>" . h($i['query']) . "</td><td>{$i['error']}</td><td style = \"text-align: right\">{$i['affected']}</td><td style = \"text-align: right\">{$i['numRows']}</td><td style = \"text-align: right\">{$i['took']}</td></tr>\n";
					endforeach;
				?>
				</tbody></table>
				<?php 
				endforeach;
			else:
				echo '<p>Encountered unexpected $logs cannot generate SQL log</p>';
			endif;	
		}
		function displayCategoryTree($pid,$level)
		{
			global $res;
			$res[0] = "-Root-";
			$blank = "";	
			
			for($i=0; $i< $level; $i++)
			$blank   .=  "-";
			
			$parents = $this->find('all' , array('conditions' => array('Category.parent_id' => $pid)));
			
			if(!empty($parents))
			$level++;
			
			foreach($parents as $value)
			{		
				unset($value['ParentCategory']);
				unset($value['Product']);
				$res[$value['Category']['id']]	= $blank.$value['Category']['name'];			
				//pr($res);
				$this->displayCategoryTree($value['Category']['id'],$level);
			}
			return $res;
		}
		/* =========================================== */
		/* 
		 *added at 30-04-12
		 *added by S.R.
		 * @param $keyword is search value
		 * @param $op an fields array to apply key value		
		 * @return array An array of model conditions
		 * @access public		
			
		*/
		/* =========================================== */
		function _keyConditions($keyword= null,$op = null){

			if ($op === null || !is_array($op) || empty($keyword)) {
				return null;
			}
			$arrayOp = array();
				
			foreach ($op as $model => $field){
				if(is_array($field)){
					foreach($field as $title){
						$arrayOp[$model][$title] = $keyword;
					}
				}else{
					$arrayOp[$model][$field] = $keyword;
				}
			}		
			return $arrayOp;
			
		}
}
?>