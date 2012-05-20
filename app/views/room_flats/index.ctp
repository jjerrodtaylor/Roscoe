	<?php e($javascript->link(array('fancybox/jquery.fancybox-1.3.4.pack','fancybox/jquery.mousewheel-3.0.4.pack'),false)); ?>
	<?php e($html->css(array('jquery.fancybox-1.3.4'),false)); ?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.addRoomFlatImage').fancybox();
	});		
	</script>
	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php $layout->sessionFlash(); ?>
		<div id="LoadingDiv" style="position:absolute;margin-top:0%;left:75%;"></div>		
		<h2 class="InnerMidCntRHd">Room/Flat List</h2>		
		<ul class="MyAccCnts" id="CustomerPaging">
			<?php e($this->element('room_flats/list_room_flat')); ?>
		</ul>
	</div>