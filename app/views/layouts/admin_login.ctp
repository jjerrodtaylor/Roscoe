<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title');?></title>    
	<?php
	  if(isset($meta_description) || isset($meta_keywords)){
	?>
	<meta name="description" content="<?php e($meta_description);?>" />
    <meta name="keywords" content="<?php e($meta_keywords);?>" /> 
     <?php
	 }
	 else{
        echo $layout->meta();
       }		
     e($html->meta('icon'));     	 
	 e($html->css(array('admin_login')));
     e($scripts_for_layout);
    ?>
    <!--[if lte IE 6]><style>
        img { behavior: url("<?php echo SITE_URL; ?>css/iepngfix.htc") }
		</style><![endif]-->
</head>
<body>
<div id="LoginWrpapper">
	<div id="header">
		<h1 class="logo">
		<?php  e($html->image('logo.png'));?>
		</h1>
	</div>
	<div class="LoginForm" id="login">
		<?php	 
		 e($content_for_layout); 
		?>
	</div>
</div>
<?php  // e($this->element('sql_dump'));?>
</body>
</html>