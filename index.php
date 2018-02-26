<?php
include_once 'config.php';
include_once 'temp/inputpolja.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once 'temp/head.php'; ?>
    
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">          
          <!-- LOGIN -->
          <div id="id2">
            <form action="authorize.php" method="post">
              <!-- username -->
              <?php inputPolje("Korisničko ime","user","text") ?>
              <!-- password -->
              <?php inputPolje("Lozinka","pass","password") ?>
              <button type="button submit" class="btn btn-primary" name="logg">Prijavi se</button>              
            </form>
            <br>
            <a href="register.php">Nemate račun?</a>
          </div>          
        </div>
      </div>
      <div class="col-sm-4">
      </div>
    </div>
  </body>
</html>