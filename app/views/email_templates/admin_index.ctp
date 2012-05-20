<div class="adminrightinner">
	<div class="tablewapper2 AdminForm">
				<h3 class="legend1">Search</h3>
      	<?php e($form->create('EmailTemplate', array('url'=>array('controller' => 'email_templates', 'action' => 'index'))));?>
					<div class="SearchRight">
					<?php e($form->create('EmailTemplate', array('url'=>array('controller' => 'email_templates', 'action' => 'index'))));?>
					<div class="input text"><?php e($form->input('EmailTemplate.name', array('label' => false, 'div'=>false,'class'=>'InputBox'))); ?> <?php e($form->submit('Search', array('div'=>false)));?> 
					</div>
					<div class="SearchRightAction">
					</div>
					<?php e($form->end());?>
					</div>
     
      <div style="clear: both;"></div>
    </div>
		<div class="fieldset">
		<h3 class="legend">
				Search Results
				<div class="total" style="float:right"> Total Products : <?php e($this->params["paging"]['EmailTemplate']["count"]);?>
				</div>
		</h3>
 <div class="adminrightinner" style="padding:0px;">
     <?php e($form->create('EmailTemplate', array('name'=>'EmailTemplate', 'url' => array('controller' => 'email_templates', 'action' => 'process'))));
		   e($form->hidden('pageAction', array('id' => 'pageAction')));
	 ?>    
	 
	   <?php
	   if(!empty($data)){
	   $exPaginator->options = array('url' => $this->passedArgs);
       $paginator->options(array('url' => $this->passedArgs));?> 
	   
	 <div class="tablewapper2">	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="EmailTemplate2Table">	
	  <tr class="head">
	   			    
		<td width="28%" align="left" valign="middle" class="Bdrrightbot Padtopbot6" style="padding-left:19px;">
		 <?php e($exPaginator->sort('Name', 'EmailTemplate.name'))?>
		</td>		
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		  <?php e($exPaginator->sort('Created', 'EmailTemplate.created'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($exPaginator->sort('Modified', 'EmailTemplate.modified'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
		<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>	
	 <?php
	   foreach($data as $value){		 
	 ?>
	 <tr>
		<td align="left" valign="middle" class="Bdrrightbot Padtopbot6" style="padding-left:19px;">
		 <?php e($value['EmailTemplate']['name']);?>
		</td>				
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['EmailTemplate']['created'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php 
		 if(!empty($value['EmailTemplate']['modified'])){
			e(date('Y-m-d',strtotime($value['EmailTemplate']['modified'])));
		 }
		?>
		</td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($layout->status($value['EmailTemplate']['status']));?></td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">		
		<?php e($admin->getActionImage(array('edit'=>array('controller'=>'email_templates', 'action'=>'edit'), 'view'=>array('controller'=>'email_templates', 'action'=>'view','token'=>$this->params['_Token']['key'])), $value['EmailTemplate']['id'], 'EmailTemplate'));?>		
		</td>
	 </tr>	
	 <?php
	  }
	 ?>
	 </table>
	 </div>
	 <?php
	  }
	 ?>
	 <?php  if(!empty($data)){ ?>
	<!-- <div class="buttonwapper">
			<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'email_templates', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
			<?php e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', 'type'=>'button', "onclick" => "javascript:return validateChk('EmailTemplate', 'activate');")));?>
			<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('EmailTemplate', 'deactivate');")));?>
			<?php e($form->submit('Delete', array('name'=>'delete', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('EmailTemplate', 'delete');")));?>
		</div>-->
		<?php 
		e($form->end());
		}
		else
		{
		?>
		<div style="color:blue, font-size:16; padding-bottom:30px;"><strong>No Records Found.</strong></div>
		<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'email_templates', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
		<?php 
		}
		?>
		
</div>
<div class="clr"></div>
<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"EmailTemplate", "total_title"=>"EmailTemplate")); ?>	 