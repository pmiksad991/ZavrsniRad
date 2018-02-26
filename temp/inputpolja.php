<?php
function inputPolje($polje,$naziv,$tip){
	?>
<div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text" id=""><?php echo $polje; ?></span>
              </div>
              <input type="<?php echo $tip; ?>" class="form-control" name="<?php echo $naziv; ?>" <?php if(isset($_POST[$naziv])): ?> value="<?php echo $_POST[$naziv] ?>" <?php endif; ?><?php if(isset($_POST["izabran2"])): ?> value="<?php if($tip=="password"){}else{echo $_POST["izabran2"]->$naziv;} ?>" <?php endif; if($tip=="password"){ echo 'minlength="6"';} ?> required>
            </div>
            <br>

<?php }  ?>