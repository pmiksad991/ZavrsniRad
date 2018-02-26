<?php

include_once 'config.php';

if(isset($_POST["logg"])){
	$pass=$_POST["pass"];
	$_POST["pass"]=md5($pass);
	$stmt=$conn->prepare("select * from korisnik where username=:username and pass=:password");
	$stmt->bindValue(":username",$_POST["user"]);
	$stmt->bindValue(":password",$_POST["pass"]);
	$stmt->execute();
	$res = $stmt->fetchAll(PDO::FETCH_OBJ);
	foreach ($res as $red) {
		if($_POST["user"]===$red->username && $_POST["pass"]===$red->pass){
			$_SESSION["connected"]=$res;
			if($_SESSION["connected"][0]->admin==1){
				header("location: private/admin.php");
			}else{
			header("location: private/index.php");
			}	
		}
	}
	if($res==null){
		header("location: index.php");
	}
	}else{
		header("location: index.php");
	}