<?php
define(
	"DEFAULT_URL",
	$_SERVER["REQUEST_URI"]
);

class Router {
	static $routes = [];
	
	static function AddRoutes(array $routes) {
		self::$routes += $routes;
	}
	
	static function Route($url = DEFAULT_URL) {
		$url = trim(
			explode("?", $url)[0],
			"/"
		);
		$args = [];
		foreach (self::$routes as $r => $defaults) {
			$args = self::Match(
				$url,
				$r,
				$defaults
			);
			
			if ($args != false) {
				break;
			}
		}
		if (!$args) {
			trigger_error(
				"No matching routes were found.",
				E_USER_ERROR
			);
		}
		$call = ($class = &$args["class"] ? "$class::" : null) . $args["function"];
		return call_user_func(
			$call,
			$args
		);
	}
	
	static function Match($url, $route, array $defaults) {
		$match = $defaults;
		$url_parts = explode(
			"/",
			trim($url, "/")
		);
		$route_parts = explode("/", trim($route, "/"));
		foreach ($route_parts as $r) {
			$part = array_shift($url_parts);
			if ($part == $r) {
				continue;
			}
			if (substr($r, 0, 1) == ":" and $key = substr($r, 1)) {
				if ($part != "") {
					$match[$key] = $part;
				}
			}
			else {
				return false;
			}
		}
		return $match;
	}
};
?>