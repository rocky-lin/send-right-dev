<div class="cfgenwp-formbuilder-l">
	
		<div id="cfgenwp-formbuilder-menu-elements" class="cfgenwp-fb-panel">
			
			<?php
			$menu_container = new MenuContainer();

			$menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('First Name');
			$menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Last Name');
			$menu_container->createMenuItem()->setMenuItemType('email')->setMenuItemName('Email Address');
			$menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Location'); 
			$menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Phone Number');
			$menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Telephone Number');
			// $menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Contact Type');  

			$menu_container->createMenuItem()->setMenuItemType('title')->setMenuItemName('Title');
			$menu_container->createMenuItem()->setMenuItemType('paragraph')->setMenuItemName('Paragraph');
			// $menu_container->createMenuItem()->setMenuItemType('email')->setMenuItemName('Email'); 
			// $menu_container->createMenuItem()->setMenuItemType('text')->setMenuItemName('Single line text');
			$menu_container->createMenuItem()->setMenuItemType('textarea')->setMenuItemName('Multi-line text');
			$menu_container->createMenuItem()->setMenuItemType('checkbox')->setMenuItemName('Checkbox');
			$menu_container->createMenuItem()->setMenuItemType('radio')->setMenuItemName('Radio button');
			$menu_container->createMenuItem()->setMenuItemType('select')->setMenuItemName('Select<span class="cfgenwp-responsive-hide-inline"> drop-down</span>');
			$menu_container->createMenuItem()->setMenuItemType('selectmultiple')->setMenuItemName('MultiSelect<span class="cfgenwp-responsive-hide-inline"> drop-down</span>');
			$menu_container->createMenuItem()->setMenuItemType('upload')->setMenuItemName('Upload');
			$menu_container->createMenuItem()->setMenuItemType('date')->setMenuItemName('Date');
			$menu_container->createMenuItem()->setMenuItemType('rating')->setMenuItemName('Rating');
			$menu_container->createMenuItem()->setMenuItemType('terms')->setMenuItemName('Terms & Conditions')->setStandsOnTwoLines(true);
			$menu_container->createMenuItem()->setMenuItemType('time')->setMenuItemName('Time');
			$menu_container->createMenuItem()->setMenuItemType('url')->setMenuItemName('URL');
			$menu_container->createMenuItem()->setMenuItemType('hidden')->setMenuItemName('Hidden input');
			$menu_container->createMenuItem()->setMenuItemType('image')->setMenuItemName('Image');
			$menu_container->createMenuItem()->setMenuItemType('separator')->setMenuItemName('Separator');
			$menu_container->createMenuItem()->setMenuItemType('captcha')->setMenuItemName('Captcha');
			$menu_container->createMenuItem()->setMenuItemType('submit')->setMenuItemName('Submit button');
			
			echo $menu_container->getHtmlMenuItems();
			
			?>
		</div>  
	</div><!-- cfgenwp-formbuilder-l -->
	