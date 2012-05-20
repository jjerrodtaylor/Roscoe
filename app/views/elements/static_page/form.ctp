<?php 
    e($javascript->link(array('fckeditor'), false));
		
?>	
	<table border="0" class="Admin2Table" width="100%">		
			  <tr>
				 <td valign="middle" class="Padleft26">Title <span class="input_required">*</span></td>
				 <td><?php e($form->input('StaticPage.title', array('div'=>false, 'label'=>false, "class" => "TextBox5")));?>
				 </td>
			  </tr>		
			 <tr>
				 <td valign="middle" class="Padleft26">Page Title <span class="input_required">*</span></td>
				 <td>
				 
					<?php
					if($this->params['action']=='admin_edit'){
						$readonly = 'readonly';
					}else{
						$readonly = '';
					}
					
					e($form->input('StaticPage.slug', array('div'=>false, 'label'=>false, "class" => "TextBox5",'readonly'=>$readonly)));
					?>
				
				 </td>
			  </tr> 	
			  <tr>
				 <td valign="middle" class="Padleft26">Description <span class="input_required">*</span></td>
				 <td>
				 <?php e($form->input('StaticPage.description', array('div'=>false, 'label'=>false, "class" => "textarea")));?>
				 <?php echo $fck->load('StaticPage/description',"Default");?>
				 </td>
			  </tr>
			  
			  <!--<tr>
				 <td valign="middle" class="Padleft26">Meta Keywords</td>
				 <td>
				 <?php #e($form->textarea('StaticPage.meta_keywords', array('div'=>false, 'label'=>false, "class" => "textarea")));?>
				 </td>
			  </tr> 
        <tr>
				 <td valign="middle" class="Padleft26">Meta Description</td>
				 <td>
				 <?php #e($form->textarea('StaticPage.meta_description',array('div'=>false, 'label'=>false, "class" => "textarea")));?>
				 </td>
			  </tr>--> 
         <tr>
				 <td valign="middle" class="Padleft26">Status</td>
				 <td>
				 <?php e($form->input('StaticPage.status', array('options'=>Configure::read('Status'),'div'=>false, 'label'=>false, "class" => "TextBox5")));?>
				 </td>
			  </tr>   			  
			
		</table>