<div class="adminrightinner">
<div class="tablewapper2 AdminForm">
	<h3 class="legend1">Search</h3>
      <?php e($form->create('Country', array('url'=>array('controller' => 'countries', 'action' => 'index'))));?>
          <table border="0" width="100%" class="Admin2Table">
            <tbody>
              <tr>
                <td width="18%" valign="middle" class="Padleft26">Country Name</td>
                <td> <?php e($form->input('Country.name', array('label' => false, 'div'=>false,'class'=>'InputBox'))); ?></td>
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
				<div class="total" style="float:right"> Total Users : <?php e($this->params["paging"]['Country']["count"]);?>
				</div>
		</h3>
 <div class="adminrightinner" style="padding:0px;">
     <?php e($form->create('Country', array('name'=>'Country', 'url' => array('controller' => 'countries', 'action' => 'process'))));
	 e($form->hidden('pageAction', array('id' => 'pageAction')));
	 e($form->hidden('token_key', array('value' => $this->params['_Token']['key'])));
	 ?>    
	  <?php
	   if(!empty($data)){
	   $exPaginator->options = array('url' => $this->passedArgs);
       $paginator->options(array('url' => $this->passedArgs));?> 
	   
	 <div class="tablewapper2">	
	 <table width="100%" border="0" cellpadding="0" cellspacing="0" class="Country2Table">	
	  <tr class="head">
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
		<input name="chkbox_n" id="chkbox_id" type="checkbox" value="" class="Chkbox" onclick="javascript:check_uncheck('Country')" />
		</td>			    
		<td width="18%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		 <?php e($exPaginator->sort('Name', 'Country.name'))?>
		</td>		
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		 <?php e($exPaginator->sort('Created', 'Country.created'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e($exPaginator->sort('Modified', 'Country.modified'))?></td>
		<td width="15%" align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">Status</td>
		<td align="center" valign="middle" class="Bdrrightbot Padtopbot6">Action</td>
	 </tr>	
	 <?php
	   foreach($data as $value){		 
	 ?>
	 <tr>
	    <td align="center" valign="middle" class="Bdrrightbot Padtopbot6">
	    <?php e($form->checkbox('Country.id'.$value['Country']['id'], array("class"=>"Chkbox", 'value'=>$value['Country']['id'] ))); ?>
	    </td>		
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		 <?php e($value['Country']['name']);?>
		</td>				
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php e(date('Y-m-d',strtotime($value['Country']['created'])));?></td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		<?php 
		 if(!empty($value['Country']['modified'])){
			e(date('Y-m-d',strtotime($value['Country']['modified'])));
		 }
		?>
		</td>
		<td align="left" valign="middle" class="Bdrrightbot" style="padding-left:19px;">
		
		<?php 
			if($value['Country']['status']=='1'){
				echo $html->link($html->image("active.png", array("title" => "Active Country", "alt" => "Active", "border" => 0)),array(''),array("escape" => false));
			}else{
				echo $html->link($html->image("deactive.png", array("title" => "Deactive Country", "alt" => "Deactive", "border" => 0)),array(''),array("escape" => false));
			}
		?>
		</td>
		<td align="center" valign="middle" class="Bdrbot ActionIcon">
		<?php 
			e($admin->getActionImage(array('edit'=>array('controller'=>'countries', 'action'=>'edit'), 'delete'=>array('controller'=>'countries', 'action'=>'delete','token'=>$this->params['_Token']['key'])), $value['Country']['id'], 'Country'));?>
<?php e($html->link($html->image('old-edit-find.png'),array('controller'=>'countries','action'=>'view_country','id'=>$value['Country']['id']),array('escape'=>false,'title'=>'View'))); 
		?>		
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
			 <?php echo $html->link("Add New", array('controller'=>'countries', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
			<?php e($form->submit('Activate', array('name'=>'activate', 'class'=>'cancel_button', 'type'=>'button', "onclick" => "javascript:return validateChk('Country', 'activate');")));?>
			<?php e($form->submit('Deactivate', array('name'=>'deactivate', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('Country', 'deactivate');")));?>
			<?php e($form->submit('Delete', array('name'=>'delete', 'type'=>'button', 'class'=>'cancel_button',  "onclick" => "javascript:return validateChk('Country', 'delete');")));?>
		</div>
		<?php e($form->end());
		}
		else
		{?>
		<div style="color:blue, font-size:20; padding-bottom:30px;padding-top:30px;padding-left:280px" ><strong>No Records Found.</strong></div>
		<div class="Addnew_button">
			 <?php echo $html->link("Add New", array('controller'=>'countries', 'action'=>'add'), array("title"=>"", "escape"=>false)); ?>
			</div>
		<?php }
		?>
		
</div>
<div class="clr"></div>
<?php echo $this->element('admin/admin_paging', array("paging_model_name"=>"Country", "total_title"=>"Country")); ?>	 