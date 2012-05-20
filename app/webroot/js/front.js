var url = window.location.href;
var url_parts = url.split('/');
var exp_path = url_parts[0]+'/'+url_parts[1]+'/'+url_parts[2]+'/'+url_parts[3];
jQuery(document).ready(function(){
   
      jQuery('.flash_good').animate({opacity: 1.0}, 8000).fadeOut();
      jQuery('.flash_bad').animate({opacity: 1.0}, 8000).fadeOut(); 
 
	/* autocomplete off  */
	jQuery('form input').attr('autocomplete', 'off');//to stop autocomplete off with each input text.	
	
  /* state at country select */
  jQuery("#UserReferenceCountryId").change(function(){
  
		jQuery('#loader_login').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");

		var country_id = jQuery(this).val();
		jQuery.ajax({
			url:SITE_URL+'/registers/state',
			data:'country_id='+country_id+'&action=front',
			dataType:'json',
			success:function(data){				
				jQuery("#stateOptions").html(data.value);
			}
			
		
		});
  
  }); 
  /* under development alert */
  jQuery("[href='#']").click(function(){
	alert('Under Development');
  });
  
   /* delete images for users in  front */
  jQuery(".delete_image").click(function(){
		var id = jQuery(this).attr('alt');
		jConfirm('Are you sure you want to delete this?','Iwantaroommate Confirm',function(r){
			if(r){
			
				jQuery('#image_loader').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");
				jQuery('#newreleaseresult').css('opacity','0.5');
				jQuery.ajax({
					url:SITE_URL+'/registers/view_image',
					type:'post',
					data:'id='+id,
					dataType:'json',
					success:function(data){
						if(data.value){
							jQuery('#newreleaseresult').css('opacity','1');	
							jQuery('#viewImage_' + id).remove();
							jQuery('#image_loader').html('');
						}else{
							alert('Any error happend to deleting data please again try.');
						}
					}
				
				
				});
			}
			return false;
		});
  
  
  });
   /* state at country select at room/flat add or edit*/
  jQuery("#RoomFlatCountryId").change(function(){
  
		jQuery('#loader_login').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");

		var country_id = jQuery(this).val();
		jQuery.ajax({
			url:SITE_URL+'/room_flats/state',
			data:'country_id='+country_id+'&action=front',
			dataType:'json',
			success:function(data){				
				jQuery("#stateOptions").html(data.value);
			}
			
		
		});
  
  });
  /* =======pagination====== */
	jQuery('#pagination-flickr a').live('click', function() {	
		var url = jQuery(this).attr("href") ;
		//alert(url); return false;
		jQuery('#LoadingDiv').html('<img src="'+SiteUrl+'/img/ajax-loader.gif'+'">');
		jQuery('#CustomerPaging').css('opacity','0.5');
		
		jQuery('#CustomerPaging').load(url, function(response, status, xhr) {			
			jQuery('#CustomerPaging').css('opacity','1');			
			jQuery('#LoadingDiv').html('');	
		});
        return false;
    });
  /* delete images for room/flat in front */
  jQuery(".delete_image_room_flat").click(function(){
		var id = jQuery(this).attr('alt');
		jConfirm('Are you sure you want to delete this?','Iwantaroommate Confirm',function(r){
			if(r){
			
				jQuery('#image_loader').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");
				jQuery('#newreleaseresult').css('opacity','0.5');
				jQuery.ajax({
					url:SITE_URL+'/room_flats/view_image',
					type:'post',
					data:'id='+id,
					dataType:'json',
					success:function(data){
						if(data.value){
							jQuery('#newreleaseresult').css('opacity','1');	
							jQuery('#viewImage_' + id).remove();
							jQuery('#image_loader').html('');
						}else{
							alert('Any error happend to deleting data please again try.');
						}
					}
				
				
				});
			}
			return false;
		});
  
  
  }); 
  /* ====delete room/flate===== */
  jQuery(".delete_room_flat").click(function(){
	var id = jQuery(this).attr('alt')
	jConfirm('Are you sure you want to delete this?','Iwantaroommate Confirm',function(r){
		if(r){
			location.href = SITE_URL+'/room_flats/delete/'+id+'/#middle';
		}
	
	});
	return false;
  });
 
});      

