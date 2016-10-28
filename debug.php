<?php

function debug() {
	if (DEBUG_MODE === false) {
		return;
	}
	
	echo '<pre>';
	$params = func_get_args();
	array_map(function ($param) {
		var_dump($param);
		echo '<br>';
	}, $params);
	echo '</pre>';
}
