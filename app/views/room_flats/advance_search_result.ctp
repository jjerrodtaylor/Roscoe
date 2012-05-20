	<A NAME="middle"></A>
	<div class="InnerMidCntR">
		<?php $layout->sessionFlash(); ?>
		<div id="LoadingDiv" style="position:absolute;margin-top:0%;left:75%;"></div>
		<h2 class="InnerMidCntRHd">Search Result</h2>		
		<ul class="MyAccCnts" id="CustomerPaging">
			<?php e($this->element('room_flats/search_result')); ?>
		</ul>
	</div>