<?php include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
if(!isset($_POST["posaljiporuku"])){
	header("location: ../logout.php");
}else{
	$stmt=$conn->prepare("insert into poruke (id, primio, poslao, sadrzaj, datum_vrijeme, procitana) values (null, :primio, :poslao, :sadrzaj, now(), null)");
	$stmt->execute(array(
    "primio"=>$_POST['prima'],
    "poslao"=>$_POST['salje'],
    "sadrzaj"=>$_POST['sadrzaj']
    ));
	header("location: poruke.php?radnici=".$_POST["prima"]);
}