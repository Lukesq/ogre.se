<div id="register">
	<form method="post">
	<?php
	if (isset($success) && $success != false) :
	?> 
	Success!
	<?php
	else :
	?> 
	<label>
		Användarnamn:<br/>
		<input type="text" name="name"/>
	</label>
	<button type="submit">
		Gå med
	</button>
	<?php
	endif;
	?> 
	</form>
</div>
