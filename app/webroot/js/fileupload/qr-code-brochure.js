
		jQuery(document).ready(function(){
		
			var hash = jQuery("#UserHash").val();
			
			var logouploader = new qq.FileUploader({
				element: document.getElementById('vertical_logo'),
				action: SITE_URL+'/fileupload_server/php.php?hash='+hash,
				debug: true,
				multiple: true,
				allowedExtensions:['jpg','JPG','jpeg','JPEG','png','PNG'],
				params: {
					tp: 'vlogo'
				},
				onSubmit: function(id, fileName){
					////$('#qq-upload-list-vertical_logo').html('');
				},
				onProgress: function(id, fileName, loaded, total){
					
				},
				onComplete: function(id, fileName, responseJSON){
					var image_count = jQuery("#image_count").val();
					
					if(responseJSON.success == true){
						var inputStr = "<input type='hidden' name='data[UserImage]["+image_count+"][image_name]' value='"+responseJSON.filename+"'/>";
						inputStr += "<input type='hidden' name='data[UserImage]["+image_count+"][hash]' value='"+hash+"'/>";					
						jQuery("#userImageList").append(inputStr);
						image_count++;
						jQuery("#image_count").val(image_count);					
					}
				}
			});
			
	});

