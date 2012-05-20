<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $title_for_layout; ?> &raquo; <?php echo Configure::read('Site.title');?></title>    
	<?php if(isset($meta_description) || isset($meta_keywords)){?>
	<meta name="description" content="<?php e($meta_description);?>" />
    <meta name="keywords" content="<?php e($meta_keywords);?>" /> 
     <?php } else{  echo $layout->meta();  }		
     e($html->meta('icon')); 
     e($html->css(array('admin', 'jquery/jquery.alerts')));
     ?>
     <script type="text/javascript">var SiteUrl = "<?php echo SITE_URL; ?>"; </script>
     <?php	  
	 echo $javascript->link(array(
					//'prototype',            		
					'jquery/jquery.min', 
					'ddaccordion',
					'jquery/jquery.cookie',			
					'jquery/jquery.collapsor',
					'jquery/jquery.alerts',                   
					'admin',
					'checkboxes_operation',
					
        ));
     e($scripts_for_layout);
    ?>
	
	<script type="text/javascript">
	 jQuery.noConflict();
	 var SITE_URL = "<?php echo SITE_URL; ?>";
	</script>
	<!--[if lte IE 6]><style>
        img { behavior: url("<?php echo SITE_URL; ?>css/iepngfix.htc") }
	</style><![endif]-->
</head>
<body>
<div id="wrapper">
	<div id="AdminSidebar">
		<div class="AdminSidebarWrapper">
			<div class="logo">
				<?php e($html->link($html->image('images/logo_small.png', array('alt'=>'Iwantaroommate Logo', 'title'=>'Iwantaroommate Logo')), array(), array('escape'=>false)));?>
			</div>
			<div class="UserMenu">
				<ul>
					<li>
						<span>Welcome,<span style="font-weight:bold;"> <?php e($html->link(ucfirst(strtolower($session->read('Auth.User.username'))),array('controller'=>'users', 'action'=>'dashboard')));?></span> &nbsp;your Control Panel</span> 
					</li>				  
				</ul>
			</div>
			<div id="left"><?php e($this->element("admin/navigation")); ?></div>
		</div>
	</div>
	<div id="right">
		<div class="AdminAction">
			
			<?php echo $html->link("logout", array('controller'=>'users', 'action'=>'logout'), array("class"=>"GreenBtn")); ?>
		
		</div>
		<H2><?php  echo  $title_for_layout;?></H2>
		<?php
			$layout->sessionFlash();
			e($content_for_layout);
		?>
	</div>
<?php //e($this->element('sql_dump'));?>
</div>
</body>
</html>