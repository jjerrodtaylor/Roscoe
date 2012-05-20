<?php e($javascript->link(array('fancybox/jquery.fancybox-1.3.4.pack','fancybox/jquery.mousewheel-3.0.4.pack'),false)); ?>
<?php e($html->css(array('jquery.fancybox-1.3.4'),false)); ?>
<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.addAttribute').fancybox();
});		
</script>

<div class="adminrightinner">
<div class="tablewapper2 AdminForm">
	<h3 class="legend1">Search</h3>
      <?php e($form->create('UserReference', array('url'=>array('admin'=>true, 'controller' => 'registers', 'action' => 'index'))));?>
          <table border="0" width="100%" class="Admin2Table">
            <tbody>
              <tr>
				<td width="18%" valign="middle" class="Padleft26">User Name :</td>
                <td><?php e($form->input('first_name', array('label' => false, 'div'=>false,'class'=>'InputBox'))); ?>  </td>
              </tr>
              <tr>
                <td valign="middle" class="Padleft26">&nbsp;</td>
                <td align="left"> 
				
                    <?php e($form->submit('Search', array('div'=>false, 'class'=>'submit_button')));?>                 
                </td>
              </tr>              
            </tbody>
          </table> 
      <?php e($form->end());?>    
      <div style="clear: both;"></div>
    </div>
  </div>
	
<div class="fieldset">
		<h3 class="legend">
				Search Results
				<div class="total" style="float:right"> Total Users : <?php e($this->params["paging"]['User']["count"]);?>
				</div>
		</h3>
 <div class="adminrightinner" style="padding:0px;">
   <?php e($form->create('User', array('name'=>'Admin', 'url' => array('controller' => 'registers', 'action' => 'process'))));?>    
	   <input type="hidden" name="pageAction" id="pageAction"/>	 
       <?php
	   if(!empty($data)){
	   $exPaginator->options = array('url' => $this->passedArgs);
       $paginator->options(array('url' => $this->passedArgs));?> 
	   
	<div class="tablewapper2">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="Admin2Table">	
		<tr class="head">
	    <td width="5%" align="center" valign="middle" class="Bdrrightbot Padtopbot6">
			<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('Admin')" />
		</td>	    
	
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;"><?php e($exPaginator->sort('Name', 'UserReference.first_name'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;"><?php e($exPaginator->sort('Email', 'User.email'))?></td>
		<td width="20%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;"><?php e($exPaginator->sort('Created Date', 'User.created'))?></td>
		<td width="5%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;">Status</td>
		<td  width="25%"  align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>	
	 <?php
	   foreach($data as $value){		 
	 ?>
	 <tr>
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
	    <?php e($form->checkbox('User.id'.$value['User']['id'], array("class"=>"Chkbox", 'value'=>$value['User']['id'] ))) ?>
	    </td>		
		
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;">
		<?php e(ucwords($value['UserReference']['first_name']).' '.$value['UserReference']['last_name']);?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;">
			<?php e($value['User']['email']);?>
		</td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;">
			<?php e($value['User']['created']);?>
		</td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:9px;">
		<?php
			if($value['User']['status']=='1'){
				echo $html->image("active.png", array("title" => "Active User", "alt" => "Active", "border" => 0));
			}else{
				echo $html->image("deactive.png", array("title" => "Deactive User", "alt" => "Deactive", "border" => 0));
			}
		?>
		</td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">
		<?php e($admin->getActionImage(array('edit'=>array('controller'=>'registers', 'action'=>'edit'), 'delete'=>array('controller'=>'registers', 'action'=>'delete','token'=>$this->params['_Token']['key']), 'changepassword'=>array('controller'=>'registers', 'action'=>'changepassword','token'=>$this->params['_Token']['key'])), $value['User']['id']));?>
		<?php e($html->link($html->image('add_user_img.jpg',array('height'=>18,'width'=>18)),array('controller'=>'registers','action'=>'addimage',$value['User']['id']),array('escape'=>false,'title'=>'Add Images'))); ?>		
		<?php e($html->link($html->image('attribute.gif'),array('controller'=>'registers','action'=>'question_answer',$value['User']['id']),array('class'=>'addAttribute','escape'=>false,'title'=>'Update Question Answer'))); ?>	
		
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
			 <?php echo $html->link("Add New", array('controller'=>'registers', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
			<?php e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Admin', 'activate');")));?>
			<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Admin', 'deactivate');")));?>
			<?php e($form->submit('Delete', array('name'=>'delete', 'class'=>'cancel_button', "type"=>"button",  "onclick" => "javascript:return validateChk('Admin', 'delete');")));?>
		</div>
		<?php e($form->end());
		}
		else
		{?>
		<div style="color:blue, font-size:20; padding-bottom:30px;padding-top:30px;padding-left:280px" ><strong>No Records Found.</strong></div>
		<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'registers', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
		<?php }
		?>
		
</div>
</div>
<div class="clr"></div>
<?php echo  $this->element('admin/admin_paging', array("paging_model_name"=>"User","total_title"=>"User")); ?>	 