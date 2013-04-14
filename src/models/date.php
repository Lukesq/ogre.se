<?php
class Date {
	static function Today($offset = "now") {
		return date("Y-m-d", strtotime($offset));
	}
	
	static function Yesterday($day = null) {
		if ($day == null) {
			$day = date("Y-m-d");
		}
		return date(
			"Y-m-d",
			strtotime("-1 day", strtotime($day))
		);
	}
	
	static function Tomorrow($day = null) {
		if ($day == null) {
			$day = date("Y-m-d");
		}
		return date(
			"Y-m-d",
			strtotime("+1 day", strtotime($day))
		);
		
	}
};
?>
