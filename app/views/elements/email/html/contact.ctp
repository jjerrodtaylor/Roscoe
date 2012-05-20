<div class="content">
	<div class="content-line" style="margin-bottom:10px;">

		Welcome Admin
		<br clear="all"><br clear="all">
		One enquiry was sended by
		<strong><?php echo ucfirst(strtolower($this->data['Contact']['name']));?></strong><br>
		<br clear="all">
		<strong>User Email:</strong><?php echo $this->data['Contact']['email'];?>
		<br clear="all"><br>
		<?php 
		if(!empty($this->data['Contact']['subject'])){?>
			<strong>User Subject:</strong>  <?php echo $this->data['Contact']['subject'];?><br clear="all"><br>
			<?php 
		}if(!empty($this->data['Contact']['message'])){
			?>
			<strong>User Enquiry Text:</strong> <?php echo $this->data['Contact']['message'];?><br clear="all"><br>
			<?php 
		}?>
		<br clear="all">
	</div>
</div>