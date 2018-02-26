<?php
include_once '../config.php';
$stmt=$conn->prepare("select b.ime, b.prezime from poruke as a inner join korisnik as b on a.poslao = b.id where a.primio=:korisnik1 and procitana is null");
$stmt->execute(array(
"korisnik1"=>$user->id
));
$noveporuke = $stmt->fetchAll(PDO::FETCH_OBJ);

$brojporuka=count($noveporuke);
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <div class="container">
    <a class="navbar-brand" href="">Zamjena Smjena<?php if($user->admin==1){ echo " - admin"; }?></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto">
        <li class="nav-item">
          <?php if($user->admin==1){ ?>
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="admin.php"||basename($_SERVER['PHP_SELF'])=="dodjela.php"||basename($_SERVER['PHP_SELF'])=="upravljanje.php"){
                      echo 'active';
                  } ?>" href="admin.php"><i class="fas fa-home"></i> Home
          </a>
          <?php }else{ ?>
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="index.php"){
                      echo 'active';
                  } ?>" href="index.php"><i class="fas fa-home"></i> Home
            
          </a>
          <?php } ?>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="poruke.php"){
                      echo 'active';
                  } ?>" href="poruke.php">
                  <?php if($brojporuka>0){ ?>
                  <i class="fas fa-envelope-open"></i> Poruke: <?php echo $brojporuka; ?></a>
                <?php }else{ ?>
                  <i class="fas fa-envelope"></i> Poruke</a>
                  <?php } ?>
        </li>
        <li class="nav-item">
          <div class="btn-group">
            <a class="nav-link <?php if(basename($_SERVER['PHP_SELF'])=="index.php"){
                      echo 'active';
                  } ?>" href="#"><i class="fas fa-user"></i><?php echo " ".$user->ime." ".$user->prezime; ?></a>
            <a class="dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true" id="btndropdown"><span class="sr-only">Toggle Dropdown</span></a>
            <div class="dropdown-menu">
              <a href="../logout.php" class="dropdown-item">Odjava</a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>
