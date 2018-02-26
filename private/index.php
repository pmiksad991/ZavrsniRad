<?php include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
$user=$_SESSION["connected"][0];
if($user->admin==1){
header("location: admin.php");
}
$stmt=$conn->prepare("select bodovi from korisnik where id=:id");
$stmt->execute(array(
"id"=>$user->id));
$bodovi = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt=$conn->prepare("select id from zamjena where korisnik1=:korisnik1 or korisnik2=:korisnik2");
$stmt->execute(array(
"korisnik1"=>$user->id,
"korisnik2"=>$user->id));
$zamjenautoku = $stmt->fetchAll(PDO::FETCH_OBJ);
if(isset($_POST["chosen"])&&empty($zamjenautoku)){
$tempArray = explode(',',$_POST["datum_korisnika"]);
$stmt=$conn->prepare("insert into zamjena (id, korisnik1, korisnik2, datum_korisnika1, datum_korisnika2, smjena_korisnika1, smjena_korisnika2, zamjena_obavljena) values (null, :korisnik1, :korisnik2, :datum_korisnika1, :datum_korisnika2, :smjena_korisnika1, :smjena_korisnika2, null)");
$stmt->execute(array(
"korisnik1"=>$_POST["korisnik1"],
"korisnik2"=>$user->id,
"datum_korisnika1"=>$_POST["korisnik1_datum"],
"datum_korisnika2"=>$tempArray[0],
"smjena_korisnika1"=>$_POST["korisnik1_smjena"],
"smjena_korisnika2"=>$tempArray[1],
));
header("location: index.php");
}
if(isset($_POST["potvrdidatum"])){
$datum = date("Y-m-d", strtotime($_POST["izabrandatum"]));
}else{
$datum = date("Y-m-d");
}
$danas = date("Y-m-d");
$stmt=$conn->prepare("select a.id, a.datum, a.id_korisnika, b.ime, b.prezime, a.id_smjene, c.naziv from dodjeljene_smjene as a inner join korisnik as b on a.id_korisnika=b.id inner join smjene as c on a.id_smjene=c.id where a.datum=:datum and b.radno_mjesto=:rmjesto");
$stmt->execute(array(
"datum"=>$datum,
"rmjesto"=>$user->radno_mjesto));
$res2 = $stmt->fetchAll(PDO::FETCH_OBJ);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_once '../temp/head.php'; ?>
    <link href="../css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
  </head>
  <body>
    <?php include_once '../temp/nav.php';
    if(empty($zamjenautoku)){}else{ ?>
    
    <div class="container" id="prvicontainer">
      <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
          <div class="alert alert-warning" role="alert">
            <strong>Zamjena u tijeku!</strong> <a data-toggle="modal" href="#myModal">Provjeri.</a>
          </div>
        </div>
        <div class="col-sm-3"></div>
      </div>
    </div>
    <?php  } if(!isset($_GET["a"])){ ?>
    <div class="container" id="prvicontainer">
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
          
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <div class="input-group">
              <input type="text" class="form-control" id="date" cols="10" name="izabrandatum">
              <div class="input-group-append">
                <button type="button submit" class="btn btn-primary" name="potvrdidatum">Potvrdi</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-sm-4">
      </div>
    </div>
    <div class="container" id="drugicontainer">
      <div class="col-sm-12">
        <strong>Bodovi: <?php echo $bodovi[0]->bodovi; ?></strong>&nbsp;&nbsp;&nbsp;<strong>Izabran datum: <?php echo date("d.m.Y",strtotime($datum)); ?></strong><br><br>
      </div>
      <div class="table-responsive">
        <table class="table table-condensed table-hover">
          <thead>
            <th>Ime</th>
            <th>Prezime</th>
            <th>Smjena</th>
            <th>Zamjena</th>
          </thead>
          <tbody>
            <?php foreach ($res2 as $red) { ?>
            <tr>
              <td><?php echo $red->ime; ?></td>
              <td><?php echo $red->prezime; ?></td>
              <td><?php echo $red->naziv; ?></td>
              <?php if($user->bodovi<1){ ?>
              <td><p id="alert">Nedovljno bodova za zamjenu!</p></td>
              <?php }else if($datum<$danas) {
              
              }else{ ?>
              <td><?php if($red->id_korisnika==$user->id){ echo ""; }else if(!empty($zamjenautoku)){ echo ""; }else { ?><a href="?a=<?php echo $red->id; ?>">zamjeni</a><?php } ?></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php }
    include_once "zamjena.php";
    ?>
    <!-- Modal -->
    <?php include_once "../temp/modalZamjena.php" ?>
    <!--modal kraj -->
    <script src="../js/bootstrap-datepicker.js"></script>
    <script>
    $('#date').datepicker({
    format: "dd.mm.yyyy",
    todayBtn: "linked",
    clearBtn: true,
    orientation: "bottom auto",
    autoclose: true
    });
    </script>
  </body>
</html>