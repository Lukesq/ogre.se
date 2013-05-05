<?php
function color($num) {
	if ($num != 0) {
		return $num > 0 ? "positive" : "negative";
	}
	else {
		return "unchanged";
	}
}
?>
<div id="browse">
	<div id="date-switch">
		<?php
		$prev = Date::Yesterday($to);
		if (!empty($highscore)) :
		?> 
		<a class="prev" href="?date=<?= $prev; ?>">
			Föregående dag
		</a>
		<?php
		endif;
		$next = Date::Tomorrow($to);
		if ($next <= Date::Today("-4 hours")) :
		?> 
		<a class="next" href="?date=<?= $next; ?>">
			Nästa dag
		</a>
		<?php
		endif;
		?> 
	</div>
	<h2>
		<pre><?= ucwords($title); ?></pre>
	</h2>
	<small>
		<?php
		$when = date("Y-m-d", strtotime($to));
		if ($when == Date::Today("-4 hours")) {
			$when = "igår";
		}
		?>
		visar resultatet från 
		<strong><?= $when; ?></strong>
	</small>
	<table id="highscore" cellpadding="0" cellspacing="0">
	
	<thead>
		<tr>
		
		<th width="50">
			Rank
			<span></span>
		</th>
		<th width="50">
			+ / -
			<span></span>
		</th>
		<th width="90">
			<?php
			echo ($type == "skill") ? "Name" 
				: "Skill";
			?> 
			<span></span>
		</th>
		<th width="35">
			Level
			<span></span>
		</th>
		<th width="55"></th>
		<th width="35">
			+ / -
			<span></span>
		</th>
		<th width="75">
			XP
			<span></span>
		</th>
		<th width="65">
			+ / -
			<span></span>
		</th>
		
		</tr>
	</thead>
	<tbody>
		<?php
		if (!empty($highscore)) :
		foreach ($highscore as $row) :
			extract($row);
		?> 
		<tr>
		
		<td>
			<?php
			$diff = 0;
			if (isset($old[$name])) {
				$diff = $old[$name]["rank"] - $rank;
			}
			echo number_format(
				$rank
			);
			?> 
		</td>
		<td class="<?= color($diff); ?>">
			<?php
			echo number_format(
				abs($diff)
			);
			?> 
		</td>
		<td>
			<?php
			$link = "?date=" . date("Y-m-d", strtotime($to));
			if ($type == "player") {
				$link = "/browse/skill/$name" . $link;
			}
			else {
				$link = "/browse/player/" . strtolower(str_replace(" ", "_", $name)) . $link;
			}
			?> 
			<a href="<?= $link; ?>">
				<pre><?= ucwords($name); ?></pre>
			</a>
		</td>
		<td>
			<?php
			$diff = 0;
			if (isset($old[$name])) {
				$diff = $level - $old[$name]["level"];
			}
			echo number_format(
				$level
			);
			?> 
		</td>
		<td>
			<?php
			if ($title == "overall" or (!empty($name) and $name == "overall")) {
				$done = round(
					($level / 2277)
					* 100
				);
			}
			else {
				$done = Skills::Progress(
					$level,
					$xp
				);
			}
			?> 
			<div class="progress">
				<div class="bar" style="width: <?= $done; ?>%;"></div>
			</div>
		</td>
		<td class="<?= color($diff); ?>">
			<?php
			echo number_format(
				abs($diff)
			);
			?> 
		</td>
		<td>
			<?php
			$diff = 0;
			if (isset($old[$name])) {
				$diff = $xp - $old[$name]["xp"];
			}
			echo number_format(
				$xp
			);
			?> 
		</td>
		<td class="<?= color($diff); ?>">
			<?php
			echo number_format(
				abs($diff)
			);
			?> 
		</td>
		
		</tr>
		<?php
		endforeach;
		else :
		?>
		<tr>
			<td class="empty" colspan="8">Här fanns det inget..</td>
		</tr>
		<?php
		endif;
		?> 
	</tbody>
	
	</table>
	<div id="stats">
		<?php
		if ($type == "skill" && !empty($highscore)) :
		?> 
		<p>
		<?php
		echo count($highscore) . " spelare";
		?> 
		</p>
		<?php
		endif;
		?> 
		<p>
		Ny dag räknas från kl 04:00
		</p>
	</div>
</div>
