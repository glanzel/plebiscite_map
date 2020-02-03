<?php
	if(is_array($value)) foreach( $value as $key => $a_value){
		echo "<label>$key</label><p>$a_value</p><br>";
	}
?>
