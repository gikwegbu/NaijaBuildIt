<?php
function log_in_customer($email,$pass){
  include 'dbconn.php';
 
    
    //salting of password
    $salt="@g26jQsG&nh*&#8v";
    $password= sha1($pass.$salt);
 try{
    $sql="SELECT email,password FROM customer WHERE email=:username";
    $s=$conn->prepare($sql);
    $s->bindValue(':username',$email);

	$s->execute();
  //  $rws= $result->fetch();
    $result=$s->fetch();
    $user=$result['email'];
    $pwd=$result['password'];  
 if($user==$email && $pwd==$password){
        
        $_SESSION['customer_login']=true;
        $_SESSION['cust_id']=$user;
   

    }
   
else{
   echo "your email or password is incorrect"; 
	header('location: .');
 
}	
    }catch(PDOExecption $e){
    	echo "error changing your password";
    		header('location: .');
    }
   return true;
}

?>