<?php
$serverName="localhost";
$dbusername="root";
$dbpassword="";
$dbname="bank_db";
try{
$conn=new PDO("mysql:host=$serverName;dbname=$dbname",$dbusername,$dbpassword);
$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$conn->exec('SET NAMES "utf8"');

}catch(PDOException $e){
	echo 'unable to connect to database  '.$e->getMessage();
	
	exit();
}
  

?>