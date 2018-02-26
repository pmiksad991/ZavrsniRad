<?php include_once '../config.php';
include_once '../temp/inputpolja.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
$user=$_SESSION["connected"][0];
if($user->admin!=1){
header("location: ../logout.php");
}
$stmt=$conn->prepare("select * from radno_mjesto");
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt=$conn->prepare("select * from korisnik");
$stmt->execute();
$res2 = $stmt->fetchAll(PDO::FETCH_OBJ);
if(isset($_POST["izabran"])){
$stmt=$conn->prepare("select * from korisnik where id=:radnici");
$stmt->execute(array(
"radnici"=>$_POST['radnici']));
$izabran = $stmt->fetchAll(PDO::FETCH_OBJ);
$_POST["izabran2"]=$izabran[0];
}
if(isset($_POST["promijeni"])){
$stmt=$conn->prepare("update korisnik set ime=:ime, prezime=:prezime, email=:mail, username=:user, admin=:admin, radno_mjesto=:radno_mjesto, bodovi=:bodovi where id=:id");
$stmt->execute(array(
"ime"=>$_POST['ime'],
"prezime"=>$_POST['prezime'],
"mail"=>$_POST['email'],
"user"=>$_POST['username'],
"admin"=>$_POST['admin'],
"radno_mjesto"=>$_POST['radno_mjesto'],
"bodovi"=>$_POST["bodovi"],
"id"=>$_POST["id"]
));
if($_POST["id"]==$user->id){
header("location: ../logout.php");
}else{
header("location: upravljanje.php");
}
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once '../temp/head.php'; ?>
    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include_once '../temp/nav.php'; ?>
    
    <?php include_once '../temp/nav2.php'; ?>
    
    <div class="container" id="prvicontainer">
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect02">Izaberi radnika</label>
              </div>
              <select class="custom-select" name="radnici">
                <?php
                foreach ($res2 as $row) {
                if($row->id==$_POST["radnici"]){
                echo '<option value="'.$row->id.'" selected>'.$row->ime.' '.$row->prezime.'</option>';
                }else{
                echo '<option value="'.$row->id.'">'.$row->ime.' '.$row->prezime.'</option>';
                }
                }
                ?>
              </select>
              <div class="input-group-append">
                <button class="btn btn-primary" type="button submit" name="izabran">Potvrdi</button>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-3"></div>
      </div>
    </div>
    <div class="container" id="drugicontainer">
      <div class="row">
        <div class="col-sm-4"></div>
        <?php if(isset($_POST["radnici"])){ ?>
        <div class="col-sm-4" id="refresh">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $_POST["izabran2"]->id; ?>">
            <?php inputPolje('Ime','ime','text'); ?>
            <br>
            <?php inputPolje('Prezime','prezime','text'); ?>
            <br>
            <?php inputPolje('E-mail','email','email'); ?>
            <br>
            <?php inputPolje('Korisničko ime','username','text'); ?>
            <br>
            <div class="input-group">
              <div class="input-group-prepend">
                <span class="input-group-text">Admin?</span>
              </div>
              <div class="input-group-text">
                <input type="radio" name="admin" value="1" <?php if($_POST["izabran2"]->admin==1){ echo "checked"; }?>>&nbsp;DA&nbsp;&nbsp;
                <input type="radio" name="admin" value="0" <?php if($_POST["izabran2"]->admin==0){ echo "checked"; }?>>&nbsp;NE
              </div>
            </div>
            <br><br>
            <?php inputPolje('Bodovi','bodovi','number'); ?>
            <br>
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect01">Radno mjesto</label>
              </div>
              <select class="custom-select" name="radno_mjesto">
                <?php
                foreach ($res as $row) {
                if($row->id==$_POST["izabran2"]->radno_mjesto){
                echo '<option value="'.$row->id.'" selected>'.$row->naziv.'</option>';
                }else{
                echo '<option value="'.$row->id.'">'.$row->naziv.'</option>';
                }
                }
                ?>
              </select>
            </div>
            <br>
            <button  class="btn btn-primary" type="button submit" name="promijeni">Potvrdi</button>
            <button class="btn btn-danger" type="button" onclick="reload()">Odbaci</button>
          </form>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <div class="row">
        <div class="col-sm-4"></div>
        <?php }else{ ?>
        <div class="col-sm-4">
          <div class="alert alert-info" role="alert">
            Izaberite korisnika.
          </div>
        </div>
        <div class="col-sm-4"></div>
      </div>
      <?php } ?>
    </div>
    <script>
    function reload(){
    window.location = 'upravljanje.php';
    }
    </script>
  </body>
</html>