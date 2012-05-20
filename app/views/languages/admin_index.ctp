<div class="SearchRighta">
		<?php e($form->create('Language', array('url'=>array('controller' => 'languages', 'action' => 'index'))));?>
				<div class="input text">
					<table width="100%" align="center" border="0" cellspacing="1" cellpadding="1">
						<tr>
								<td>Languages Name <?php e($form->input('Language.name', array('label' => false, 'div'=>false,'class'=>'InputBox1'))); ?> </td>
						<td align="right"><?php e($form->submit('Search', array('div'=>false)));?> </td>
						</tr>
					</table>
				</div>
		<?php e($form->end());?>
</div>
 <div class="adminrightinner">
     <?php e($form->create('Language', array('name'=>'Language', 'url' => array('controller' => 'languages', 'action' => 'process'))));?>    
	    <input type="hidden" name="pageAction" id="pageAction"/>	 
   	   <?php
	   if(!empty($data)){
	   $exPaginator->options = array('url' => $this->passedArgs);
       $paginator->options(array('url' => $this->passedArgs));?> 

	 <div class="tablewapper2">	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="User2Table">	
	  <tr class="head">
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
			<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('Language')" />
		</td>	    
		<td width="30%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($exPaginator->sort('Code', 'Language.code'))?>
		</td>
		<td width="20%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Language Name</td>
		<td width="20%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
		<td  width="20%"align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>	
	 <?php
	   foreach($data as $value){		 
	 ?>
	 <tr>
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
	    <?php e($form->checkbox('Language.languages_id'.$value['Language']['id'], array("class"=>"Chkbox", 'value'=>$value['Language']['id'] ))) ?>
	    </td>		
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($value['Language']['name']);?> &nbsp;
		<?php if($value['Language']['set_as_default']=='true'){ echo '(<span style="color:#000;">Default)</span>';} ?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($value['Language']['code']);?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php
			if($value['Language']['status']=='1'){
				echo $html->link($html->image("active.png", array("title" => "Active Country", "alt" => "Active", "border" => 0)),array(''),array("escape" => false));
			}else{
				echo $html->link($html->image("deactive.png", array("title" => "Deactive Country", "alt" => "Deactive", "border" => 0)),array(''),array("escape" => false));
			}
		?>
		</td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">
		<?php e($admin->getActionImage(array('edit'=>array('controller'=>'languages', 'action'=>'edit'), 'delete'=>array('controller'=>'languages', 'action'=>'delete','token'=>$this->params['_Token']['key'])), $value['Language']['id']));?>
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
	 <div class="buttonwapper">
			<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'languages', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
			<?php e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Language', 'activate');")));?>
			<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Language', 'deactivate');")));?>
			<?php e($form->submit('Delete', array('name'=>'delete', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Language', 'delete');")));?>
		</div>
		<?php e($form->end());
		}
		else
		{?>
		<div style="color:blue, font-size:16; padding-bottom:30px;"><strong>No Records Found.</strong></div>
		<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'languages', 'action'=>'add'), array("title"=>"", "escape"=>false)); 			?>
			</div>
		<?php }
		?>
		
</div>
<div class="clr"></div>
<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"Language","total_title"=>"Language")); ?>	 
<?php #echo $this->element('User/User_paging', array("paging_model_name"=>"User","total_title"=>"User")); ?>	 