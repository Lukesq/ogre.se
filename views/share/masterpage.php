<!doctype html>
<html>
	<head>
	
	<meta charset="utf-8"/>
	<title>Ogre — Svensktoppen</title>
	
	<link rel="stylesheet" href="/css/style.css">
	
	</head>
	<body>
	
	<div id="header">
		<div id="skills">
		
		<a class="current" href="">
		<span class="arrow"></span>
		<?php
		if ($type == "skill") :
		?>
		<img src="/img/<?= $title; ?>.gif" width="16" height="16"/>
		<?php
		endif;
		echo $type == "skill" ? ucfirst($title)
			: "Välj skill";
		?> 
		</a>
		<ul class="list" style="display: none;">
		<?php
		foreach (Skills::$skills as $skill) :
		?> 
		<li>
			<?php
			$link = "/skill/$skill";
			$class = "";
			if (isset($title) and lcfirst($skill) == $title) {
				$class = "active";
			}
			?>
			<a class="<?= $class; ?>" href="<?= $link; ?>">
			<img src="/img/<?= $skill; ?>.gif" width="16" height="16"/>
			<?php
			echo ucfirst($skill);
			?> 
			</a>
		</li>
		<?php
		endforeach;
		?> 
		</ul>
		
		</div>
	</div>
	
	<div id="contents">
	<?php
	echo $body;
	?> 
	</div>
	
	<script src="/js/lib/jquery-1.9.1.min.js"></script>
	<script src="/js/main.js"></script>
	
	</body>
</html>