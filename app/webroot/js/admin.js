var url = window.location.href;
var url_parts = url.split('/');
var exp_path = url_parts[0]+'/'+url_parts[1]+'/'+url_parts[2]+'/'+url_parts[3];
//alert(exp_path);

ddaccordion.init({
	headerclass: "submenuheader", //Shared CSS class name of headers group
	contentclass: "submenu", //Shared CSS class name of contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click", "clickgo", or "mouseover"
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false
	defaultexpanded: [5], //index of content(s) open by default [index1, index2, etc] [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: true, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["", ""], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["suffix", "<img src='"+exp_path+"/img/admin/firest_li_bg1.gif' class='statusicon' />", "<img src='"+exp_path+"/img/admin/firest_li_bg.jpg' class='statusicon' />"], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "normal", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})

ddaccordion.init({ //2nd level headers initialization
	headerclass: "subexpandable", //Shared CSS class name of sub headers group that are expandable
	contentclass: "subcategoryitems", //Shared CSS class name of sub contents group
	revealtype: "click", //Reveal content when user clicks or onmouseover the header? Valid value: "click" or "mouseover
	mouseoverdelay: 200, //if revealtype="mouseover", set delay in milliseconds before header expands onMouseover
	collapseprev: true, //Collapse previous content (so only one open at any time)? true/false 
	defaultexpanded: [], //index of content(s) open by default [index1, index2, etc]. [] denotes no content
	onemustopen: false, //Specify whether at least one header should be open always (so never all headers closed)
	animatedefault: false, //Should contents open by default be animated into view?
	persiststate: true, //persist state of opened contents within browser session?
	toggleclass: ["opensubheader", "closedsubheader"], //Two CSS classes to be applied to the header when it's collapsed and expanded, respectively ["class1", "class2"]
	togglehtml: ["none", "", ""], //Additional HTML added to the header when it's collapsed and expanded, respectively  ["position", "html1", "html2"] (see docs)
	animatespeed: "fast", //speed of animation: integer in milliseconds (ie: 200), or keywords "fast", "normal", or "slow"
	oninit:function(headers, expandedindices){ //custom code to run when headers have initalized
		//do nothing
	},
	onopenclose:function(header, index, state, isuseractivated){ //custom code to run whenever a header is opened or closed
		//do nothing
	}
})
jQuery(document).ready(function(){
   jQuery('.deleteItem').bind('click',function(){
		var target_url = jQuery(this).attr("href");
          jConfirm('Are you sure you want to delete?','Iwantaroommate Confirm', function(r) {
              if(r){
                 
            	  location.href = target_url;
              }
          }
        );
         return false;

      })
      // fade out good flash messages after 4 seconds
      jQuery('.flash_good').animate({opacity: 1.0}, 4000).fadeOut(); 
 
	var selectFlag = 0;
	jQuery(".select_checkbox").click( function() { 
			
		if( !selectFlag  ) {
			jQuery(".status_checkbox").each( function() {
				jQuery(".select_checkbox").attr("checked", "true");										 													 
				jQuery(this).attr("checked", "true");
			 });
			selectFlag = 1;
		} else {
			jQuery(".status_checkbox").each( function() {
				jQuery(".select_checkbox").removeAttr("checked");										 
				jQuery(this).removeAttr("checked");
			 });
			selectFlag = 0;				
		}
  });
	
	/* autocomplete off  */
	
	jQuery('form input').attr('autocomplete', 'off');//to stop autocomplete off with each input text.	
	
  /* state at country select at user add or edit*/
  jQuery("#UserReferenceCountryId").change(function(){
  
		jQuery('#loader_login').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");

		var country_id = jQuery(this).val();
		jQuery.ajax({
			url:SITE_URL+'/registers/state',
			data:'country_id='+country_id+'&action=admin',
			dataType:'json',
			success:function(data){				
				jQuery("#stateOptions").html(data.value);
			}
			
		
		});
  
  });
   /* state at country select at room/flat add or edit*/
  jQuery("#RoomFlatCountryId").change(function(){
  
		jQuery('#loader_login').html("<img src='"+SITE_URL+"/img/ajax-loader.gif' border='0' />");

		var country_id = jQuery(this).val();
		jQuery.ajax({
			url:SITE_URL+'/room_flats/state',
			data:'country_id='+country_id+'&action=admin',
			dataType:'json',
			success:function(data){				
				jQuery("#stateOptions").html(data.value);
			}
			
		
		});
  
  }); 
  /* delete images for users in admin */
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
  /* delete images for room/flat in admin */
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
  
  
  

 });

      

