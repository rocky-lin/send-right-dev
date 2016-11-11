<?php
class MenuItem{
	
	function __construct(){
		$this->stands_on_two_lines = false;
	}
	
	function setMenuItemType($value){
		$this->item_type = $value;
		return $this;
	}
	
	function getMenuItemType(){
		return $this->item_type;
	}
	
	function setMenuItemName($value){
		$this->item_name = $value;
		return $this;
	}
	
	function getMenuItemName(){
		return $this->item_name;
	}
	
	function setStandsOnTwoLines($value){
		$this->stands_on_two_lines = $value;
		
		return $this;
	}
	
	function getStandsOnTwoLines(){
		return $this->stands_on_two_lines;
	}
	
	function getHtmlMenuItem(){
		
		$cfgenwp_2lines_class = $this->getStandsOnTwoLines() ? 'cfgenwp-2lines' : '';	
		
		$html = '<div class="cfgenwp-addelement '.$cfgenwp_2lines_class.' add-'.$this->getMenuItemType().'" data-cfgenwp_type="'.$this->getMenuItemType().'">'
				.$this->getMenuItemName()
				.'</div>';

		return $html;
		
	}
}

class MenuContainer{

	function createMenuItem(){
		
		$menu_item = new MenuItem();
		
		$this->menu_items[] = $menu_item;
		
		return $menu_item;
	}
	
	function getMenuItems(){
		return $this->menu_items;
	}
	
	function getHtmlMenuItems(){
		
		$html = '';
		
		foreach($this->getMenuItems() as $menu_item){
			$html .= $menu_item->getHtmlMenuItem();
		}
		
		return $html;
	}

}
?>