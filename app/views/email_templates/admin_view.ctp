<div class="adminrightinner">
<div class="tablewapper2 AdminForm">	

	<table border="0" class="Admin2Table" width="100%">		
			  <tr>
				 <td valign="middle" class="Padleft26" width="20%">Name</td>
				 <td><?php e($this->data['EmailTemplate']['name']);?></td>
			  </tr>
			  <tr>
				 <td valign="middle" class="Padleft26">Alias</td>
				 <td><?php e($this->data['EmailTemplate']['alias']);?></td>
			  </tr>
			  <tr>
				 <td valign="middle" class="Padleft26">Subject</td>
				 <td><?php e($this->data['EmailTemplate']['subject']);?></td>
			  </tr>
			 
			  <tr>
				 <td valign="middle" class="Padleft26">Description</td>
				 <td><?php e($this->data['EmailTemplate']['description']);?></td>
			  </tr>  
             
             <tr>
				 <td valign="middle" class="Padleft26">Status</td>
				 <td>
				 <?php e($layout->status($this->data['EmailTemplate']['status']));?></td>
			  </tr>   			  
			
		</table>
	</div>	
			<div class="Addnew_button" style="margin-top:15px;">
			 <?php echo $html->link("Back", array('controller'=>'email_templates', 'action'=>'index'), array("title"=>"", "escape"=>false)); ?>
			</div>	
</div>