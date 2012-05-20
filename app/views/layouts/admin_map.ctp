<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
 <title>
	<?php echo $title_for_layout; ?> | <?php echo Configure::read('Site.title');?>
 </title>
<link rel="icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
<link rel="shortcut icon" href="<?php echo $this->webroot;?>favicon.ico" type="image/x-icon" />
 
	<?php
	  if(isset($meta_description) || isset($meta_keywords)){
	  if(isset($meta_description) && !empty($meta_description)){
	?>
	<meta name="description" content="<?php e($meta_description);?>" />
	 <?php
	  }
	  if(isset($meta_keywords) && !empty($meta_keywords)){
	?>
    <meta name="keywords" content="<?php e($meta_keywords);?>" /> 
     <?php
	   }
	 }
	 else{
        echo $layout->meta();
       }	
	 ?>  
<?php   
		e($html->css(array(	'front')));
		e($html->meta('icon'));
?>
<?php
 e($javascript->link(array(
					'jquery/jquery',
					'ddaccordion',
					'front',					
	)));
?>

<script type="text/javascript">
	jQuery.noConflict();
	var SiteUrl = "<?php echo SITE_URL; ?>";
	var SITE_URL = "<?php echo SITE_URL; ?>";	
</script>
<!--[if lte IE 6]><style>
        img { behavior: url("<?php echo SITE_URL; ?>/css/iepngfix.htc") }
</style><![endif]-->
	 <?php e($scripts_for_layout);?>
	 <?php //echo $html->css("/popup/css/default_theme"); ?>
</head>
<body>
<div id="Wraper">
	<?php e($content_for_layout); ?> 
</div>
<?php   //e($this->element('sql_dump'));?>
</body>
</html>