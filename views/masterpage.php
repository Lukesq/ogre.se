<!doctype html>
<html>
	<head>
	
	<meta charset="utf-8"/>
	<title>Ogre — Svensktoppen</title>
	
	<link rel="shortcut icon" href="/img/favicon.png"/>
	<link rel="stylesheet" href="/css/style.css"/>
	
	<script>
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-32934487-2']);
	_gaq.push(['_trackPageview']);
	(function() {
	var ga = document.createElement('script'); 
	ga.type = 'text/javascript';
	ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0];
	s.parentNode.insertBefore(ga, s);
	})();
	</script>
	
	</head>
	<body>
	
	<div id="header">
		<h1 id="logo">
			<a href="/">
				<img src="/img/logo.png" width="156" height="54" alt="Ogre.se, Runescape Svensktoppen"/>
			</a>
		</h1>
		<div id="skills">
		
		<a class="current" href="">
		<span class="arrow"></span>
		<?php
		if (!isset($type)) {
			$type = null;
		}
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
		<div id="registration">
			<a href="/register">Registrera dig här</a>
		</div>
	</div>
	
	<div id="contents">
	<?php
	echo $body;
	?> 
	</div>
	
	<div id="footer">
		<ul>
		
		<li>
			© 2013 Ogre.se
		</li>
		<li>/</li>
		<li>
			<a target="_blank" href="https://github.com/erming/ogre.se">
				GitHub
			</a>
		</li>
		<li>/</li>
		<li>
			<a target="_blank" href="http://webchat.quakenet.org/?channels=runescape.se">
				#runescape.se @ QuakeNet
			</a>
		</li>
		
		</ul>
	</div>
	
	<script src="/js/lib/jquery-1.9.1.min.js"></script>
	<script src="/js/main.js"></script>
	
	</body>
</html>