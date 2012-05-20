<div id="navigation">
	<div class="glossymenu">
			<?php /**************************** Admin Management Management Start*****************************/?>			
      <?php e($html->link('Admin Management', array(), array('class'=>'menuitem submenuheader')));?>
			<div class="submenu">
            <ul>
                <li><?php e($html->link(__('List Admin User', true), array('controller'=>'users', 'action'=>'index')));?></li>
                <li><?php //e($html->link(__('Add Admin User', true), array('controller'=>'users', 'action'=>'add')));?></li>               
            </ul>
			</div>	
			<?php /**************************** Admin Management Management End*****************************/?>			
			<?php /**************************** Registered Users Management Start*****************************/?>			
			<?php e($html->link('User Management', array(), array('class'=>'menuitem submenuheader')));?>
				<div class="submenu">
                    <ul>
                        <li><?php e($html->link(__('List Users', true), array("controller"=>"registers", "action"=>"index")));?></li>
                        <li>
						<?php e($html->link(__('Add User', true), array("controller"=>"registers", "action"=>"add")));?>
						</li>                        
                    </ul>
				</div>
			<?php /**************************** Room/Flat Type Management Start*****************************/?>			
			<?php e($html->link('Room/Flat Type Management', array(), array('class'=>'menuitem submenuheader')));?>
				<div class="submenu">
                    <ul>
						<li><?php e($html->link(__('List Room/Flat Type', true), array("controller"=>"room_flat_types", "action"=>"index")));?></li>
                        <li>
						<?php e($html->link(__('Add Room/Flat Type', true), array("controller"=>"room_flat_types", "action"=>"add")));?>
						</li>                        
                    </ul>
				</div>	
			<?php /**************************** Room/Flat Management Start*****************************/?>			
			<?php e($html->link('Room/Flat Management', array(), array('class'=>'menuitem submenuheader')));?>
				<div class="submenu">
                    <ul>
                        <li><?php e($html->link(__('List Room/Flat', true), array("controller"=>"room_flats", "action"=>"index")));?></li>
                        <li>
						<?php e($html->link(__('Add Room/Flat', true), array("controller"=>"room_flats", "action"=>"add")));?>
						</li>                        
                    </ul>
				</div>					
			<?php /**************************** Registered Users Management Start*****************************/?>			
			
			<?php /**************************** Email Template Management Start*****************************/?>
			<?php  e($html->link('Email Template Management', array(), array('class'=>'menuitem submenuheader')));?>	
			<div class="submenu">
				<ul>
					<li><?php e($html->link(__('List Email Templates', true), array("controller"=>"email_templates", "action"=>"index")));?></li>
					<li>
					<?php //e($html->link(__('Add Email Template', true), array("controller"=>"email_templates", "action"=>"add")));?>
					</li>                        
				</ul>
			 </div>
			<?php e($html->link('Global Settings Management', array(), array('class'=>'menuitem submenuheader')));?>
			<div class="submenu">
				<ul>
					<li><?php e($html->link(__('Global Settings Management List', true), array('plugin' => null, 'controller'=>'settings', 'action'=>'index')));?></li>
					<li>
					<?php # e($html->link(__('Add Voucher', true), array("controller"=>"vouchers", "action"=>"add")));?>
					</li>                        
				</ul>
			</div>
			<?php /**************************** Lacation Management Start****************************/?>
			 <?php e($html->link('Location Management', array(), array('class'=>'menuitem submenuheader')));?>
				<div class="submenu">
				<ul>
					<li>
					<?php e($html->link('Country Management', array(), array('class'=>'menuitem subexpandable')));?>	
					<div class="subcategoryitems">
					  <ul>
						<li><?php e($html->link(__('List Countries', true),array('plugin' => null, 'controller'=>'countries', 'action'=>'index')));?>
						</li>
						<li><?php e($html->link(__('Add Country', true), array('plugin' => null, 'controller'=>'countries', 'action'=>'add')));?>
						</li>               
					  </ul>
					</div>
					</li>	
					<li>					
					<?php e($html->link('State Management', array(), array('class'=>'menuitem subexpandable')));?>	
					<div class="subcategoryitems">
					<ul>
					<li><?php e($html->link(__('List States', true), array('plugin' => null, 'controller'=>'states', 'action'=>'index')));?>
					</li>
					<li><?php e($html->link(__('Add State', true), array('plugin' => null, 'controller'=>'states', 'action'=>'add')));?>
					</li>               
					</ul>
					</div>
					</li>
				</ul>
				</div>
			<?php /**************************** Amenity Management Start*****************************/?>
			<?php  e($html->link('Amenity Management', array(), array('class'=>'menuitem submenuheader')));?>	
			<div class="submenu">
				<ul>
					<li><?php e($html->link(__('List Amenities', true), array("controller"=>"amenities", "action"=>"index")));?></li>
					<li>
					<?php e($html->link(__('Add Amenities', true), array("controller"=>"amenities", "action"=>"add")));?>
					</li>                        
				</ul>
			 </div>	
			<?php /**************************** Question Management Start*****************************/?>
			<?php  e($html->link('Question Management', array(), array('class'=>'menuitem submenuheader')));?>	
			<div class="submenu">
				<ul>
					<li><?php e($html->link(__('List Questions', true), array("controller"=>"question_options", "action"=>"index")));?></li>
					<li>
					<?php e($html->link(__('Add Question', true), array("controller"=>"question_options", "action"=>"add")));?>
					</li>                        
				</ul>
			 </div>	
				<?php /**************************** Product Management End ****************************/?>
				<?php /**************************** Static Page Management Start*****************************/?>
		      <?php e($html->link('Static Page Management', array('controller'=>'pages', 'action'=>'index'), array('class'=>'menuitem submenuheader')));?>
				<div class="submenu">
                    <ul>
                        <li>
						<?php e($html->link(__('List Pages', true), 
						array('controller'=>'static_pages', 'action'=>'index'))); ?>
						</li>
                        <li>
						<?php e($html->link(__('Add Page', true), array('controller'=>'static_pages', 'action'=>'add'))); ?>
						</li>                        
                    </ul>
				</div>	
				 <?php /**************************** Static Page Management End*****************************/?>

			 
</div>
</div>