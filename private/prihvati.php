<?php
include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
if(isset($_GET["b"])){
$stmt=$conn->prepare("select * from zamjena where id=:id");
$stmt->execute(array(
"id"=>$_GET["b"]));
$res = $stmt->fetchAll(PDO::FETCH_OBJ);
$zamjena=$res[0];
print_r($zamjena);
echo "<br>";

$stmt=$conn->prepare("select id from dodjeljene_smjene where id_korisnika=:id_korisnika1 and datum=:datum_korisnika1");
$stmt->execute(array(
"id_korisnika1"=>$zamjena->korisnik1,
"datum_korisnika1"=>$zamjena->datum_korisnika1));
$res = $stmt->fetchAll(PDO::FETCH_OBJ);
$dod_smjene = $res[0];
print_r($dod_smjene);
echo "<br>";

$stmt=$conn->prepare("select id from dodjeljene_smjene where id_korisnika=:id_korisnika2 and datum=:datum_korisnika2");
$stmt->execute(array(
"id_korisnika2"=>$zamjena->korisnik2,
"datum_korisnika2"=>$zamjena->datum_korisnika2));
$res = $stmt->fetchAll(PDO::FETCH_OBJ);
$dod_smjene2 = $res[0];
print_r($dod_smjene2);
echo "<br>";


$stmt=$conn->prepare("update dodjeljene_smjene set id_korisnika=:korisnik2 where id=:id");
$stmt->execute(array(
"korisnik2"=>$zamjena->korisnik2,
"id"=>$dod_smjene->id
));
$stmt=$conn->prepare("update dodjeljene_smjene set id_korisnika=:korisnik1 where id=:id");
$stmt->execute(array(
"korisnik1"=>$zamjena->korisnik1,
"id"=>$dod_smjene2->id
));
$stmt=$conn->prepare("delete from zamjena where id=:id");
$stmt->execute(array(
"id"=>$zamjena->id
));

$stmt=$conn->prepare("update korisnik set bodovi=bodovi-1 where id=:korisnik2");
$stmt->execute(array(
"korisnik2"=>$zamjena->korisnik2
));

$stmt=$conn->prepare("update korisnik set bodovi=bodovi+1 where id=:korisnik1");
$stmt->execute(array(
"korisnik1"=>$zamjena->korisnik1
));
if($_SESSION["connected"][0]->admin!=1){
	header("location: index.php");
}else{
	header("location: admin.php");
}
}else{
	header("location: ../logout.php");
}
