<div id="register">
	
	<?php
	if (!isset($success) || $success != true) :
	?> 
	<h2>
		Registrering
	</h2>
	<form method="post">
	
	<label>
		Användarnamn:<br/>
		<input type="text" name="name"/>
	</label>
	<?php
	if (isset($success)) :
	?>
	<p class="error">
		Spelaren kunde inte hittas på Runescapes officiella highscore.
	</p>
	<?php
	endif;
	?>
	<button type="submit">
		Gå med
	</button>
	
	</form>
	<?php
	else :
	?> 
	<div class="success">
	
	<h2>
		Registrerad!
	</h2>
	<p>
		Du är nu registrerad på Svensktoppen!
	</p>
	
	</div>
	<?php
	endif;
	?> 
</div>
