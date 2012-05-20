<div class="SearchRight">
	<?php e($form->create('StaticPage', array('url'=>array('controller' => 'static_pages', 'action' => 'index'))));?>
	<div class="input text"><label>Search by name</label> 
	<?php e($form->input('StaticPage.title', array('label' => false, 'div'=>false,'class'=>'InputBox'))); ?> <?php e($form->submit('Search', array('div'=>false)));?> 
	</div>
	<div class="SearchRightAction">
	</div>
	<?php e($form->end());?>
</div>

<div class="adminrightinner">
     <?php e($form->create('StaticPage', array('name'=>'StaticPage', 'url' => array('controller' => 'static_pages', 'action' => 'process'), 'onsubmit'=>"return false;")));?> 
       <input type="hidden" name="pageAction" id="pageAction"/>	 
     <?php 	
	 //e($form->hidden('StaticPage.pageAction', array('id'=>'pageAction', 'value'=>'')));?>
	<?php       
	   if(!empty($data)){
	   $exPaginator->options = array('url' => $this->passedArgs);
       $paginator->options(array('url' => $this->passedArgs));
	 ?>
	 <div class="tablewapper2">	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Admin2Table">	
	  <tr class="head">
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
		<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('StaticPage')" />
		</td>	    
		<td width="28%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Page Name', 'StaticPage.title'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Created</td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Modified</td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
		<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>
	 <?php
	   foreach($data as $value){   		  
	 ?>
	 <tr>
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
	    <?php e($form->checkbox('StaticPage.id'.$value['StaticPage']['id'], array("class"=>"Chkbox", 'value'=>$value['StaticPage']['id'] )))?>	    
	    </td>		
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($value['StaticPage']['title']);?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['StaticPage']['created'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['StaticPage']['modified'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($layout->status($value['StaticPage']['status']));?></td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">
		<?php e($admin->getActionImage(array('edit'=>array('controller'=>'static_pages', 'action'=>'edit')), $value['StaticPage']['id']));?>		
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
	 <?php //e($form->input('StaticPage.sumadfnt', array('id'=>'df', 'type'=>'hidden')));?>
    
			<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'static_pages', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>			
			<?php e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', 'type'=>'button', "onclick" => "javascript:return validateChk('StaticPage', 'activate');")));?>
			<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'class'=>'cancel_button','type'=>'button',  "onclick" => "javascript:return validateChk('StaticPage', 'deactivate');")));?>					
		</div>
		
	<?php e($form->end());
		}
		else
		{?>
		<div style="color:blue, font-size:16; padding-bottom:30px;"><strong>No Records Found.</strong></div>
		<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'static_pages', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
		<?php 
		}
		?>
</div>
<div class="clr"></div>
<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"StaticPage","total_title"=>"Static Pages")); ?>	 