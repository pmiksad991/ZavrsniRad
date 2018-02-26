<?php include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
$user=$_SESSION["connected"][0];
$stmt=$conn->prepare("select * from poruke where primio=:korisnik1 or poslao=:korisnik2");
$stmt->execute(array(
"korisnik1"=>$user->id,
"korisnik2"=>$user->id
));
$poruke = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt=$conn->prepare("select b.id, b.ime, b.prezime from poruke as a inner join korisnik as b on a.poslao = b.id where a.primio=:korisnik1 and procitana is null group by a.poslao");
$stmt->execute(array(
"korisnik1"=>$user->id
));
$noveporuke2 = $stmt->fetchAll(PDO::FETCH_OBJ);
$stmt=$conn->prepare("select * from korisnik");
$stmt->execute();
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
		if($user->admin==1){
			include_once '../temp/nav2.php';
		} ?>
		
		<div class="container" id="prvicontainer">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<?php foreach ($noveporuke2 as $red) {
					?>
					<div class="alert alert-info" role="alert">
						Nova poruka od <a href="?radnici=<?php echo $red->id; ?>"><strong><?php echo $red->ime." ".$red->prezime; ?>!</strong></a>.
					</div>
					<?php
					} ?>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
		<div class="container" id="prvicontainer">
			<div class="row">
				<div class="col-sm-2"></div>
				<div class="col-sm-8">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
						<div class="input-group">
							<div class="input-group-prepend">
								<label class="input-group-text" for="inputGroupSelect02">Izaberi radnika</label>
							</div>
							<select class="custom-select" name="radnici">
								<?php
								foreach ($res2 as $row) {
								if($row->id==$_GET["radnici"]){
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
					<hr>
					<?php if(!isset($_GET["radnici"])){}else{ ?>
					<div id="poruke">
						<?php
						if(isset($_GET["radnici"])){
						$stmt=$conn->prepare("select * from poruke where (primio = :korisnik1 and poslao = :korisnik2) or (primio = :korisnik3 and poslao = :korisnik4)");
						$stmt->execute(array(
						"korisnik1"=>$user->id,
						"korisnik2"=>$_GET["radnici"],
						"korisnik3"=>$_GET["radnici"],
						"korisnik4"=>$user->id
						));
						$poruke2 = $stmt->fetchAll(PDO::FETCH_OBJ);
						foreach ($poruke2 as $red) {
						if($red->primio==$user->id&&$red->procitana!=1){
						$stmt=$conn->prepare("update poruke set procitana=1 where id=".$red->id);
						$stmt->execute();
						}
						}
						}
						
						foreach ($poruke2 as $row) {
							if($row->primio==$user->id){
						?>
						<p align="left"><span id="small"><?php echo date("d.m.Y. H:i",strtotime($row->datum_vrijeme)); ?></span></p>
						<p align="left"><span id="primio"><?php echo $row->sadrzaj; ?></span></p>
						<?php
						}else{
						?>
						<p align="right"><span id="small"><?php echo date("d.m.Y. H:i",strtotime($row->datum_vrijeme)); ?></span></p>
						<p align="right"><span id="poslao"><?php echo $row->sadrzaj; ?></span></p>
						<?php
						}
						} ?>
					</div>
					<br>
					<form action="posaljiporuku.php" method="POST">
						<input type="hidden" name="salje" value="<?php echo $user->id; ?>">
						<input type="hidden" name="prima" value="<?php echo $_GET["radnici"]; ?>">
						<div class="input-group">
							<input type="text" class="form-control" id="basic-url" aria-describedby="basic-addon3" name="sadrzaj" required>
							<div class="input-group-append">
								<button class="btn btn-primary" type="button submit" name="posaljiporuku">Pošalji</button>
							</div>
						</div>
					</form>
					<?php } ?>
				</div>
				<div class="col-sm-2"></div>
			</div>
		</div>
		<script>
   				$('#poruke').scrollTop($('#poruke')[0].scrollHeight);
		</script>
	</body>
</html>