<?php
require_once dirname(__FILE__) . "/simple_html_dom.php";

define(
	"HIGHSCORE_URL",
	"http://services.runescape.com/m=hiscore_oldschool/hiscorepersonal.ws?user1="
);

class Crawler {
	static function Fetch($username) {
		if (empty($username)) {
			return false;
		}
		
		$c = curl_init();
	
		curl_setopt($c, CURLOPT_URL, HIGHSCORE_URL . $username);
		curl_setopt($c, CURLOPT_HEADER, 0);

		ob_start();

		curl_exec($c);
		$html = str_get_html(ob_get_clean());

		curl_close($c);
		
		if (empty($html)) {
			return false;
		}
		
		$tables = $html->find("table");
		if (count($tables) < 3) {
			return false;
		}
		
		$stats = [];
		$tr = array_slice(
			$html->find("table")[2]->find("tr"),
			3
		);
		
		foreach ($tr as $r) {
			$td = $r->find("td");
			
			$skill = strtolower(trim($td[1]->find("a")[0]->innertext));
			$stats[$skill] = [];
			
			$i = 2;
			foreach (["rank", "level", "xp"] as $t) {
				$stats[$skill][$t] = str_replace(",", "", $td[$i]->innertext);
				$i++;
			}
		}
		
		return $stats;
	}
};
?>
