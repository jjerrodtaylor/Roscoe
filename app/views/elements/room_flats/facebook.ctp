
	<?php 
	$name =ucfirst($data['RoomFlatType']['name']).' ,'.ucfirst($data['RoomFlat']['street_address']) . "," . ucfirst($data['RoomFlat']['city_name']) . "," . ucfirst($data['State']['name']) . "-" . $data['RoomFlat']['zipcode'].",".$data['Country']['iso_code'];
	if(!empty($data['RoomFlatImage'])){
		$large_image_path = SITE_URL.'/img/'.IMAGE_ROOM_FLAT_FOLDER_NAME.'/'.$data['RoomFlatImage'][0]['hash'].'/uploaded_large/'.$data['RoomFlatImage'][0]['image_name'];
		
	}else{
		$large_image_path = SITE_URL.'/img/home.jpg';
	}
	//echo $large_image_path;
	//echo $data['RoomFlat']['description'];
	?>
	
	
	<div id="fb-root"></div>
	<script src="http://connect.facebook.net/en_US/all.js"></script>
	<script type="text/javascript">
		function setFeed(){
			FB.init({appId: '308312515911569', status: true, cookie: true, xfbml: true});
			FB.ui(
				{
				method: 'feed',
				name: '<?php e($name);?>',
				link: '<?php e(SITE_URL);?>',
				picture: '<?php e($large_image_path);?>',
				caption: '<?php e(Configure::read('Site.title')); ?>',
				description: '<?php e($text->truncate($data['RoomFlat']['description'],100));?>',
				message: ''
				},
				function(response) {
					if (response && response.post_id) {
						alert('Shared Successfully');
					} 
				}
			);
		}
	</script>
	
	<img src='<?php e(SITE_URL);?>/img/Share_button.png'  onclick="setFeed();" style='cursor:pointer' />
	