<div class="container" id="druginav">
	<div class="col"></div>
	<div class="col">
		<a href="admin.php" <?php if(basename($_SERVER['PHP_SELF'])=="admin.php"){
                      echo 'class="active"';
                  } ?>>Pregled smjena</a>
        &nbsp;&nbsp;&nbsp;
        <a href="dodjela.php"<?php if(basename($_SERVER['PHP_SELF'])=="dodjela.php"){
                      echo 'class="active"';
                  } ?>>Dodjela smjena</a>
        &nbsp;&nbsp;&nbsp;
        <a href="upravljanje.php"<?php if(basename($_SERVER['PHP_SELF'])=="upravljanje.php"){
                      echo 'class="active"';
                  } ?>>Upravljanje korisnicima</a>
	</div>
	<div class="col"></div>
</div>