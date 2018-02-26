<?php include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
$user=$_SESSION["connected"][0];
if($user->admin!=1){
header("location: ../logout.php");
}
$stmt=$conn->prepare("select a.id, a.ime, a.prezime, b.naziv from korisnik as a inner join radno_mjesto as b on a.radno_mjesto=b.id");
$stmt->execute();
$res2 = $stmt->fetchAll(PDO::FETCH_OBJ);
if(isset($_POST["izabran"])){
$stmt=$conn->prepare("select a.id, a.ime, a.prezime, b.naziv from korisnik as a inner join radno_mjesto as b on a.radno_mjesto=b.id where a.id=:radnici");
$stmt->execute(array(
"radnici"=>$_POST['radnici']));
$izabran = $stmt->fetchAll(PDO::FETCH_OBJ);
$_POST["izabran2"]=$izabran[0];
}
$stmt=$conn->prepare("select * from smjene");
$stmt->execute();
$res = $stmt->fetchAll(PDO::FETCH_OBJ);


if(isset($_POST["potvrdpostavljeno"])){
  $datumArray = explode(',',$_POST["datum"]);
  foreach ($datumArray as $red) {
    $datumformat = date("Y-m-d", strtotime($red));
    $stmt=$conn->prepare("insert into dodjeljene_smjene (id, id_korisnika, id_smjene, datum) values (null, :id_korisnika, :id_smjene, :datum)");
    $stmt->execute(array(
    "id_korisnika"=>$_POST['id'],
    "id_smjene"=>$_POST['smjena'],
    "datum"=>$datumformat
    ));
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
        <div class="col-sm-3">
        </div>
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
        <div class="col-sm-3">
        </div>
      </div>
      <?php
      if(isset($_POST["izabran2"])){
      ?>
      <div class="row">
        <div class="col-sm-12">
          <br>
          <strong>Radno mjesto zaposlenika: <?php echo $_POST["izabran2"]->naziv; ?></strong>
          <hr>
        </div>
      </div>



       <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group">
              <div class="input-group-prepend">
                <label class="input-group-text" for="inputGroupSelect02">Smjena</label>
              </div>
              <select class="custom-select" name="smjena">
                <?php
                foreach ($res as $row) {
                echo '<option value="'.$row->id.'">'.$row->naziv.'</option>';
                }
                ?>
              </select> 
            </div>
            <br>
              <div class="input-group">
                <div class="input-group-prepend">
                <span class="input-group-text" id="">Dani</span>
              </div>
              <input type="text" class="form-control" id="date" cols="10" name="datum">  
            </div>
            <input type="hidden" name="id" value="<?php echo $_POST["izabran2"]->id; ?>">
            <br>
            <button type="button submit" class="btn btn-primary" name="potvrdpostavljeno">Potvrdi</button>
            <button class="btn btn-danger" type="button" onclick="reload()">Odbaci</button>
          </form>
        </div>
        <div class="col-sm-3">
        </div>
      </div>



      <?php }else{} ?>
    </div>
    <div class="container" id="drugicontainer">
    </div>
    <script src="../js/bootstrap-datepicker.js"></script>
    <script>
    $('#date').datepicker({
    format: "dd.mm.yyyy",
    clearBtn: true,
    orientation: "bottom auto",
    multidate: true
    });
    </script>
    <script>
    function reload(){
    window.location = 'dodjela.php';
    }
    </script>
  </body>
</html>