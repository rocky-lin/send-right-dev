<?php
	// PHP VERSION CHECK
	if(!$cfgenwp_editor_obj->isphp5()){
		echo $cfgenwp_editor_obj->warning_php5;
		echo '</div></body></html>';
		exit;
	}
	?>