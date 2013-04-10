<?php
function Redirect($url) {
	header("Location: $url");
	die();
}

function Import($file, array $args = []) {
	extract($args);
	ob_start();
	if (file_exists($file)) {
		include $file;
		return ob_get_clean();
	}
}

function ArrayColumnValueAsKey($key, array $arr) {
	$new = [];
	foreach ($arr as $row) {
		$new[$row[$key]] = $row;
	}
	return $new;
}
?>
