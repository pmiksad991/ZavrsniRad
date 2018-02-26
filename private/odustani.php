<?php
include_once '../config.php';
if(!isset($_SESSION["connected"])){
header("location: ../logout.php");
}
$stmt=$conn->prepare("delete from zamjena where id=:id");
$stmt->execute(array(
"id"=>$_GET["b"]));
if($_SESSION["connected"][0]->admin!=1){
	header("location: index.php");
}else{
	header("location: admin.php");
}