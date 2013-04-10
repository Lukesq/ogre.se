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
	<h2>
		<?php
		echo ucwords($title);
		?> 
	</h2>
	<small>
		visar resultat från <?= $from; ?> till <?= $to; ?>
	</small>
	<table id="highscore" cellpadding="0" cellspacing="0">
	
	<thead>
		<tr>
		
		<th>
			Rank
		</th>
		<th>
			+ / -
		</th>
		<th>
			<?php
			echo ($type == "skill") ? "Name" 
				: "Skill";
			?> 
		</th>
		<th>
			Level
		</th>
		<th width="50"></th>
		<th>
			+ / -
		</th>
		<th>
			XP
		</th>
		<th>
			+ / -
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
			if (isset($old[$key])) {
				$diff = $old[$key]["rank"] - $rank;
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
			if ($type == "player") {
				$link = "/skill/$key";
			} else {
				$link = "/" . strtolower(str_replace(" ", "+", $key));
			}
			?>
			<a href="<?= $link; ?>">
			<?php
			echo ($type == "player") ? ucfirst($key)
				: ucwords($key);
			?> 
			</a>
		</td>
		<td>
			<?php
			$diff = 0;
			if (isset($old[$key])) {
				$diff = $level - $old[$key]["level"];
			}
			echo number_format(
				$level
			);
			?> 
		</td>
		<td>
			<?php
			if ($title == "overall" or (!empty($key) and $key == "overall")) {
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
			if (isset($old[$key])) {
				$diff = $xp - $old[$key]["xp"];
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
</div>
