<?php
include_once 'config.php';
include_once 'temp/inputpolja.php';

if(isset($_POST['regg'])){
$stmt=$conn->prepare("select id from korisnik where username=:user");
$stmt->execute(array(
"user"=>$_POST["user"]));
$check = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt=$conn->prepare("select id from korisnik where email=:mail");
$stmt->execute(array(
"mail"=>$_POST["mail"]));
$check2 = $stmt->fetchAll(PDO::FETCH_OBJ);
$broj2 = count($check2);
if($_POST['pass']===$_POST['pass2']){
  if($broj!=1){
    if($broj2!=1){
      $stmt=$conn->prepare("insert into korisnik (id, ime, prezime, email, username, pass, admin, radno_mjesto, bodovi) values (null, :ime, :prezime, :mail, :user, :pass, :admin, :radno_mjesto, :bodovi)");
$stmt->execute(array(
    "ime"=>$_POST['ime'],
    "prezime"=>$_POST['prezime'],
    "mail"=>$_POST['mail'],
    "user"=>$_POST['user'],
    "pass"=>md5($_POST['pass']),
    "admin"=>0,
    "radno_mjesto"=>$_POST['radno_mjesto'],
    "bodovi"=>2
    ));
header("location: index.php");
}else{
  $message = "E-mail se već koristi";
echo "<script type='text/javascript'>alert('$message');</script>";
}
}else{
$message = "Korisničko se već koristi";
echo "<script type='text/javascript'>alert('$message');</script>";
}
}else{
$message = "Lozinke moraju biti jednake";
echo "<script type='text/javascript'>alert('$message');</script>";
}
}
$stmt=$conn->prepare("select * from radno_mjesto");
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_OBJ);
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
          <!-- REGISTER -->
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <!-- ime -->
            <?php inputPolje("Ime","ime","text") ?>
            <!-- prezime -->
            <?php inputPolje("Prezime","prezime","text") ?>
            <!-- email -->
            <?php inputPolje("E-mail","mail","email") ?>
            <!-- username -->
            <?php inputPolje("Korisničko ime","user","text") ?>
            <!-- password -->
            <?php inputPolje("Lozinka","pass","password") ?>
            <!-- password repeat -->
            <?php inputPolje("Ponovite lozinku","pass2","password") ?>
            <!-- radno mjesto -->
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Radno mjesto</label>
              </div>
              <select class="custom-select" name="radno_mjesto">
                <?php
                foreach ($res as $row) {
                echo '<option value="'.$row->id.'">'.$row->naziv.'</option>';
                }
                ?>
              </select>
            </div>
            <br>
            <button type="button submit" class="btn btn-primary" name="regg">Registriraj se</button>
          </form>
          <br>
          <a href="index.php">Već registriran?</a>
        </div>
      </div>
    </div>
    <div class="col-sm-4">
    </div>
  </div>
</body>
</html>