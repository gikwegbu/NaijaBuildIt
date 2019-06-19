<?php
function change_staff_pass($id,$new,$new_again,$old){
	 include 'dbconn.php';
      
            	try{
            $sql="SELECT * FROM staff WHERE email='$id'";
            $result=$conn->query($sql);
            $rws= $result->fetch();
            }catch(PDOException $e){
       echo "error in retrieving your details,please try again later";
            }
            if($rws[9]==$old && $new==$new_again){
            	try{
                $sql="UPDATE staff SET pwd=:new WHERE email=:user";
                $s=$conn->prepare($sql);
				$s->bindValue(':new',$new);
								$s->bindValue(':old',$id);
								$s->execute();
               }catch(PDOException $e){
           echo 'password change failed, please try again later'.$e->getMessage(); 
		   
               }
			   header('location:staff_homepage.php');
			   
            }
            else{
                /* give the pop up window about something went wrong try again*/
			echo 'an error occurred, please check your entered values and retry';
                header('location:change_password_staff.php');
            }
			
            }
            
            
	







?>