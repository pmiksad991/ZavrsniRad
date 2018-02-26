<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?php
        $stmt=$conn->prepare("select korisnik1, korisnik2 from zamjena");
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        if($result[0]->korisnik1==$_SESSION["connected"][0]->id){
          $stmt=$conn->prepare("select a.id, b.ime, b.prezime, a.datum_korisnika1, a.datum_korisnika2, a.smjena_korisnika1, a.smjena_korisnika2 from zamjena as a inner join korisnik as b on b.id=a.korisnik2 where a.korisnik1=:korisnik1");
          $stmt->execute(array(
            "korisnik1"=>$_SESSION["connected"][0]->id));
            $primio = $stmt->fetchAll(PDO::FETCH_OBJ); //print_r($primio);?>
            <strong>Vaša smjena:</strong> <?php if($primio[0]->smjena_korisnika1==1){ echo "prva";}else{echo "druga";} echo " - ".date("d.m.Y",strtotime($primio[0]->datum_korisnika1)); ?>
            <br>
            <br>
            <strong>Mjenjate za:</strong> <?php if($primio[0]->smjena_korisnika2==1){ echo "prva";}else{echo "druga";} echo " - ".date("d.m.Y",strtotime($primio[0]->datum_korisnika2)); ?>
            <br><br>
            <strong>S korisnikom:</strong> <?php echo $primio[0]->ime." ".$primio[0]->prezime; ?>
            <br><br>
            <a href="prihvati.php?b=<?php echo $primio[0]->id; ?>" type="button" class="btn btn-primary">Prihvati</a>
            <a href="odustani.php?b=<?php echo $primio[0]->id; ?>" type="button" class="btn btn-danger">Odustani</a>
          <?php
        }else{
          $stmt=$conn->prepare("select a.id, b.ime, b.prezime, a.datum_korisnika1, a.datum_korisnika2, a.smjena_korisnika1, a.smjena_korisnika2 from zamjena as a inner join korisnik as b on b.id=a.korisnik1 where a.korisnik2=:korisnik2");
          $stmt->execute(array(
            "korisnik2"=>$_SESSION["connected"][0]->id));
            $poslao = $stmt->fetchAll(PDO::FETCH_OBJ); //print_r($poslao);?>
            <strong>Vaša smjena:</strong> <?php if($poslao[0]->smjena_korisnika2==1){ echo "prva";}else{echo "druga";} echo " - ".date("d.m.Y",strtotime($poslao[0]->datum_korisnika2)); ?>
            <br>
            <br>
            <strong>Mjenjate za:</strong> <?php if($poslao[0]->smjena_korisnika1==1){ echo "prva";}else{echo "druga";} echo " - ".date("d.m.Y",strtotime($poslao[0]->datum_korisnika1)); ?>
            <br><br>
            <strong>S korisnikom:</strong> <?php echo $poslao[0]->ime." ".$poslao[0]->prezime; ?>
            <br><br>
            <a href="odustani.php?b=<?php echo $poslao[0]->id; ?>" type="button" class="btn btn-danger">Odustani od zamjene</a>
          <?php
        }
        ?>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn" data-dismiss="modal">Zatvori</a>
      </div>
    </div>​