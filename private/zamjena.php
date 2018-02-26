<?php
  if(isset($_GET["a"])){
  $stmt=$conn->prepare("select a.id, a.id_korisnika, a.id_smjene, a.datum, b.ime, b.prezime, c.naziv from dodjeljene_smjene as a inner join korisnik as b on a.id_korisnika=b.id inner join smjene as c on c.id=a.id_smjene where a.id=:a");
  $stmt->execute(array(
  "a"=>$_GET["a"]));
  $res3 = $stmt->fetchAll(PDO::FETCH_OBJ);
  }
  //print_r($res3);
  $stmt=$conn->prepare("select a.id, a.datum, a.id_smjene, b.naziv from dodjeljene_smjene as a inner join smjene as b on a.id_smjene=b.id where id_korisnika = :user and datum>=CURDATE() order by datum asc");
  $stmt->execute(array(
  "user"=>$user->id));
  $res4 = $stmt->fetchAll(PDO::FETCH_OBJ);
  //print_r($res4);
  ?>

    <?php if(isset($_GET["a"])){ ?>
<div class="container" id="trecicontainer">
  
  <div class="row">
    <div class="col-sm-1"></div>
    <div class="col-sm-4" id="border">
      <br>
      <h4>Izabrana zamjena:</h4><br>
      <div class="input-group">
        <span class="input-group-text" id="">Ime</span>
        <input type="text" class="form-control" placeholder="<?php echo $res3[0]->ime;  ?>" disabled>
      </div>
      <br>
      <div class="input-group">
        <span class="input-group-text" id="">Prezime</span>
        <input type="text" class="form-control" placeholder="<?php echo $res3[0]->prezime;  ?>" disabled>
      </div>
      <br>
      <div class="input-group">
        <span class="input-group-text" id="">Datum</span>
        <input type="text" class="form-control" placeholder="<?php echo date("d.m.Y", strtotime($res3[0]->datum)); ?>" disabled>
      </div>
      <br>
      <div class="input-group">
        <span class="input-group-text" id="">Smjena</span>
        <input type="text" class="form-control" placeholder="<?php echo $res3[0]->naziv;  ?>" disabled>
      </div>
      <br>
    </div>
    <div class="col-sm-1"></div>
    <div class="col-sm-5" id="border">
      <br>
      <h4>Izaberite smjenu:</h4>
      <br>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
        <div class="input-group">
          <div class="input-group-prepend">
            <label class="input-group-text" for="inputGroupSelect02">Izaberi datum</label>
          </div>
          <select class="custom-select" name="datum_korisnika">
            <?php
            foreach ($res4 as $row) {
            echo '<option value="'.$row->datum.','.$row->id_smjene.'">'.date("d.m.Y", strtotime($row->datum)).' - '.$row->naziv.' smjena</option>';
            }
            ?>
          </select>

        </div>
        <input type="hidden" value="<?php echo $res3[0]->id_korisnika; ?>" name="korisnik1">
        <input type="hidden" value="<?php echo $res3[0]->datum; ?>" name="korisnik1_datum">
        <input type="hidden" value="<?php echo $res3[0]->id_smjene; ?>" name="korisnik1_smjena">
        <br>
      <button class="btn btn-primary" type="button submit" name="chosen">Potvrdi</button>
      <a href="admin.php" class="btn btn-danger" type="button">Odustani</a>
      </form>
    </div>
    <div class="col-sm-1"></div>
  </div>
</div>

<?php     } ?>