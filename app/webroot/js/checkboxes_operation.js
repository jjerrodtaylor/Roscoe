
function check_uncheck(FormName)
{
	
	var formElementCount = document.forms[FormName].elements.length;
	
	for(i=0;i<formElementCount;i++)
	{
		if(document.getElementById('chkbox_id').checked == true)
		{			
			if(document.forms[FormName].elements[i].type == 'checkbox')
			{
				document.forms[FormName].elements[i].checked = true;
			}
		}
		else
		{
			if(document.forms[FormName].elements[i].type == 'checkbox')
			{
				document.forms[FormName].elements[i].checked = false;
			}
		}
	}
}


function validateChk(frmName, action)
{	
	var frm_length=document.forms[frmName].elements.length;
	var chk_length=0;
	var chk_total=0;
  
  
	for(i=0;i<frm_length;i++)
	{
		if(document.forms[frmName].elements[i].type=="checkbox")
		{
			
			if(document.forms[frmName].elements[i].checked  && document.forms[frmName].elements[i].name!="chkbox_n" )
				chk_length++;
			else
				chk_total++;
		}
	}
	
	if(chk_length==0)
	{
		if(chk_total==1)
		{
			jAlert("There is nothing to delete.", "Iwantaroommate Alert");
		}
		else
		{
			jAlert("Please select at least one checkbox", "Iwantaroommate Alert");
		}
		
		return false;
	}
	else
	{
	
	 if(action == "delete"){ 
	   jConfirm('Are you sure you want to delete?','Iwantaroommate Confirm', function(r) {
             
			 if(r){  
				
            	 jQuery('#pageAction').val('delete');	  
            	 document.forms[frmName].submit();            	
            	  return true;
              }
          }
        );
	 
	  return false;
	 } 
	 
	 if(action == "activate"){ 
		   jConfirm('Are you sure you want to activate?','Iwantaroommate Confirm', function(r) {
	              if(r){
	            	  
					  jQuery('#pageAction').val('activate');
	            	  document.forms[frmName].submit();            	  
	            	  return true;
	              }
	          }
	        );
		 
		  return false;
		 } 
	 if(action == "deactivate"){ 
		   jConfirm('Are you sure you want to deactivate?','Iwantaroommate Confirm', function(r) {
	              if(r){
				      jQuery('#pageAction').val('deactivate');	            	 
	            	  document.forms[frmName].submit();            	  
	            	  return true;
	              }
	          }
	        );
		 
		  return false;
		 } 
		 
		 if(action == "addsubcategory"){ 
		   jConfirm('Are you sure you want to add?','Iwantaroommate Confirm', function(r) {
	              if(r){
				      jQuery('#pageAction').val('addsubcategory');	            	 
	            	  document.forms[frmName].submit();            	  
	            	  return true;
	              }
	          }
	        );
		 
		  return false;
		 } 
		 
	
	}
	return true;
}






