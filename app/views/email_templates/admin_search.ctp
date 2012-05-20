<?php //echo $this->element('msg_display'); ?>
<div style="margin-left:400px;">
        <?php e($form->create('City', array('url'=>array('controller' => 'cities', 'action' => 'index'))));?>
        <div class="input text"><label>Search by name</label>
               <?php e($form->input('City.name', array('label' => false, 'div'=>false))); ?>
        </div>
            <div style="padding-left:55px;"><?php e($form->submit('Search', array('div'=>false)));?>
            &nbsp;&nbsp;<?php e($form->button('Clear', array('div'=>false, 'type'=>'reset', 'class'=>'ui-state-default', 'onclick'=>'return blank_keyword();')));?>
            &nbsp;&nbsp;<?php e($form->button('Reset', array('div'=>false, 'type'=>'reset', 'class'=>'ui-state-default', 'onclick'=>'return reset_result();')));?>
           </div>
        <?php e($form->end());?>
    </div>
	
<div class="adminrightinner">
     <?php e($form->create('City', array('name'=>'City', 'url' => array('controller' => 'cities', 'action' => 'index'))));?>     <?php
	   	   if(!empty($result)){
//echo "<pre>";	   
	  // print_r($result);die;?>
	   <div class="tablewapper2">	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Admin2Table">	
	  <tr class="head">
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
		<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('City')" />
		</td>	    
		<td width="28%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;"><?php e($exPaginator->sort('Name', 'City.name'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Created</td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Modified</td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
		<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>	
	 <?php
	   foreach($result as $value){	  
	 ?>
	 <tr>
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
	    <?php echo $form->input($value["City"]["id"], array("type"=>"checkbox","label"=>false, "multiple" => "checkbox", "class"=>"Chkbox")); ?>
	    </td>
		
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($value['City']['name']);?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['City']['created'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['City']['modified'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($layout->status($value['City']['status']));?></td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">
		<?php e($admin->getActionImage(array('edit'=>array('controller'=>'cities', 'action'=>'edit'), 'delete'=>array('controller'=>'cities', 'action'=>'delete','token'=>$this->params['_Token']['key'])), $value['City']['id']));?>		
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
	 <div class="buttonwapper">
			<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'cities', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
			<div><input type="submit" value="Delete" class="cancel_button" /></div>
		</div>
		
</div>
}
<div class="clr"></div>
<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"City","total_title"=>"City")); ?>	 