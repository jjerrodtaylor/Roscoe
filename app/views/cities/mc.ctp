<?php App::import('Vendor', 'mailchimp/MCAPI.class.php'); ?>
<div id="mailchimp">
<?php //echo $mailchimp->linkedList($lists, '/' . $this->params['controller'] .  '/mclist_view/'); ?>

<?php 
	$api = new MCAPI('ed6b6d0d12de19035a402d6a9db170e2-us2');
	$merge_vars = array(
'FNAME' => stripslashes('anil 123'),
'LNAME' => stripslashes('yadav 123'),
'OPTINIP' => $_SERVER['REMOTE_ADDR']
);
	$retval = $api->listSubscribe("a09f1ac7b5", 'khetaram.sansi2@octalsoftware.net', $merge_vars, "html", false); 
	print_r($retval);
	
?>
</div> 