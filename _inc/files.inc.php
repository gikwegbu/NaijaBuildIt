<?php



function simpleUpload($uploadfile,$uploadname,$mimetype){
		$type='';
		include 'dbconn.php';

   	
	
	
	  switch($mimetype){
	  case 'image/gif':
	  case 'image/jpg':
	  case 'image/jpeg':
	  $type='image';
	  break;
	  /**
	  case 'text/plain':
	  $type='text';
	  break;
	  case 'text/pdf':
	  $type='pdf';
	  break;
	  case 'video/mp4':
	  case 'video/mpeg':
	  $type='video';
	  break;
	  case 'audio/mp3':
	  $type='audio';
	  break;
	  **/
	 default:
	  $type='unknown';
	  echo "file must be an image";
	  //header('location: .');
	  break;
	  }
	 
  $filepath='../uploads/' . time() . $_SERVER['REMOTE_ADDR'].$uploadname;
 
// Copy the file (if it is deemed safe)
if (!is_uploaded_file($uploadfile) or
    !copy($uploadfile, $filepath))
{
	
	if ($_FILES['file']['error'] > 0)
{

switch ($_FILES['file']['error'])
{
case 1:  
 $uploadstatus='File exceeded upload_max_filesize';  break;
 
case 2:  
 $uploadstatus=
'File exceeded max_file_size';  break;

case 3:  
 $uploadstatus=
 'File only partially uploaded';  break;
 
case 4:  
 $uploadstatus=
'No file uploaded';  break;
}
}
	
	
	
	
 echo "Could not save file as $filepath!";
//header('location: .');
}

$fileInfo[]=array('filepath'=>$filepath,'type'=>$type,'mimetype'=>$mimetype);
  return $filepath;
	
}
/**
function uploadFile(){
	session_start();
if(isset($_POST['description'])){
		$type='';
		include 'db.inc.php';
	if (!is_uploaded_file($_FILES['file']['tmp_name']))
  {
    $output = 'There was no file uploaded!';
    include $_SERVER['DOCUMENT_ROOT'] . '/ceet/includes/alerts.php';
    exit();
  }
  $uploadfile = $_FILES['file']['tmp_name'];
  
  
  
  
  $uploadname = $_FILES['file']['name'];
  $uploadtype = $_FILES['file']['type'];
	
	
	  switch($uploadtype){
	  case 'image/gif':
	  case 'image/jpg':
	  case 'image/jpeg':
	  $type='image';
	  break;
	  case 'text/plain':
	  $type='text';
	  break;
	  case 'text/pdf':
	  $type='pdf';
	  break;
	  case 'video/mp4':
	  case 'video/mpeg':
	  $type='video';
	  break;
	  case 'audio/mp3':
	  $type='audio';
	  break;
	  
	 default:
	  $type='unknown';
	  break;
	  }
	 
  $filepath=$_SERVER['DOCUMENT_ROOT'].'/ceet/uploads/' . time() . $_SERVER['REMOTE_ADDR'].$uploadname;
 
// Copy the file (if it is deemed safe)
if (!is_uploaded_file($uploadfile) or
    !copy($uploadfile, $filepath))
{
	
	if ($_FILES['file']['error'] > 0)
{

switch ($_FILES['file']['error'])
{
case 1:  
 $uploadstatus='File exceeded upload_max_filesize';  break;
 
case 2:  
 $uploadstatus=
'File exceeded max_file_size';  break;

case 3:  
 $uploadstatus=
 'File only partially uploaded';  break;
 
case 4:  
 $uploadstatus=
'No file uploaded';  break;
}
}
	
	
	
	
  $output = "Could not save file as $filepath!";
  include $_SERVER['DOCUMENT_ROOT'] . '/ceet/includes/alerts.php';
  exit();
}
  
  
  
  //preview
  
  if(is_uploaded_file($_FILES['filepreview']['tmp_name'])){
  
  $prevuploadfile = $_FILES['filepreview']['tmp_name'];
  
  
  $prevuploadname = $_FILES['filepreview']['name'];
  $prevuploadtype = $_FILES['filepreview']['type'];
  
  if($prevuploadtype!='image/jpg' and $prevuploadtype!='image/jpeg' and $prevuploadtype!='image/png' and $prevuploadtype!='image/gif' ){
  	echo 'only images allowed for preview';
  	
  }
  $previewpath='/ceet/uploads/' . time() . $_SERVER['REMOTE_ADDR'].$prevuploadname;
  $prevfilename =$_SERVER['DOCUMENT_ROOT'].$previewpath;
// Copy the file (if it is deemed safe)
if (!is_uploaded_file($prevuploadfile) or
    !copy($prevuploadfile, $prevfilename))
{
	
	
	if ($_FILES['file']['error'] > 0)
{

switch ($_FILES['file']['error'])
{
case 1:  
 $uploadstatus='File exceeded upload_max_filesize';  break;
 
case 2:  
 $uploadstatus=
'File exceeded max_file_size';  break;

case 3:  
 $uploadstatus=
 'File only partially uploaded';  break;
 
case 4:  
 $uploadstatus=
'No file uploaded';  break;
}

}

 
	
	
  $output = "Could not save previewfile as $prevfilename!";
  include $_SERVER['DOCUMENT_ROOT'] . '/ceet/includes/alerts.php';
  
  
  
  
  exit();
}
  }
  
 include 'db.inc.php';
 
 try{
 	$sql='insert into uploads set mimetype=:uptype, filepath=:filepath,filename=:name,type=:type,dateuploaded=:date,description=:description,previewpath=:preview,byuser=:by';
 	$s=$pdo->prepare($sql);
 	$s->bindValue(':filepath',$filepath);
 	 	$s->bindValue(':type',$type);
 	 	 	 	$s->bindValue(':uptype',$uploadtype);
 	 	
 	 	$s->bindValue(':date',date('y-m-d'));
 	 	$s->bindValue(':description',$_POST['description']);
 	 	
  
 	 	
 	 	 	$s->bindValue(':preview',$previewpath);
 	 	 	
 	 	 	 	 	 	$s->bindValue(':name',$_POST['filename']);
 	 	 	$s->bindValue(':by',$_SESSION['id']);
 	$s->execute();
 	
 }
	catch(PDOException $e){
		echo 'couldnt upload file'.$e->getMessage();
	}

	
	}
}









function retrieveFollowedUploads(){
	session_start();
	
	include 'db.inc.php';
	try{
		
	$s=$pdo->query('select uploads.id, filepath,previewpath,followers.followerid,followers.followedid,filename,byuser,type,users.name from uploads
	inner join followers on byuser=followedid
	inner join users on followedid=users.id
	where followerid='.$_SESSION['id']);
	
	

	}
		catch(PDOException $e){
		echo 'couldnt retrieve person files'.$e->getMessage();
	}
	
	$result=$s->fetchAll();
	return $result;
	
}





function retrieveAllUploads(){
	if(!isset($_SESSION['check'])){	session_start();
	}
	
	include 'db.inc.php';
	try{
		
	$s=$pdo->query('select * from uploads');
	
	}
		catch(PDOException $e){
		echo 'couldnt retrieve files'.$e->getMessage();
	}
	
	$result=$s->fetchAll();
	return $result;
	
}





function retrieveUserUploads(){
	
	
	include 'db.inc.php';
	try{
	$s=$pdo->query('select * from uploads inner join followers on followedid='.$_SESSION['personid'].' and followerid='.$_SESSION['id'].' where byuser='.$_SESSION['personid']);
	}
		catch(PDOException $e){
		echo 'couldnt retrieve person files'.$e->getMessage();
	}
	$result=$s->fetch();
	return $result;
}




function retrieveMyUploads(){
	
	include 'db.inc.php';
	try{
	$s=$pdo->query('select * from uploads where byuser='.$_SESSION['id']);
	}
		catch(PDOException $e){
		echo 'couldnt retrieve your files'.$e->getMessage();
	}
	$result=$s->fetch();
	return $result;
}


function autoFollow($id){
	include 'db.inc.php';
	try{
	$s1=$pdo->query('select courseid from students_course where studentid='.$id);
	
	}
	catch(PDOException $e){
		echo 'couldnt retrieve courseid'.$e->getMessage();
	}
	$result1=$s1->fetchAll();
	
	
		try{
	$s2=$pdo->query('select count(*) from students_course where studentid!='.$id);
	
	}
	catch(PDOException $e){
		echo 'couldnt count courses'.$e->getMessage();
	}
	$result2=$s2->fetchAll();
	

if($result1 and $result2[0]>0){
	
	foreach($result1 as $row1){
		foreach($result2 as $row2){
			if($row1['courseid']==$row2['courseid']){
		try{
			
			$s=$pdo->query('select from followers where followedid='.$id.' and followerid='.$row1['studentid']);
		}
		
			catch(PDOException $e){
		echo 'couldnt select from followers'.$e->getMessage();
	}
		$result=$s->fetch();
		if($result[0]>0){
			try{
				$pdo->exec('update followers set followerid='.$row2['studentid'].' where followedid='.$id);
				
			}	catch(PDOException $e){
		echo 'couldnt update followers'.$e->getMessage();
	}
		}
		
		elseif(!($result[0]>0)){
			try{
				$pdo->query('insert into followers  set followedid='.$id.',followerid='.$row2['studentid']);
			}
			
				catch(PDOException $e){
		echo 'couldnt insert into followers'.$e->getMessage();
	}
		}
		}
			}
		}
	}
}



function retrieveUpload($id){
   
   
	
	include 'db.inc.php';
	try{
		
	$sql='select uploads.id as id,uploads.description, uploads.filepath as filepath,previewpath,filestore.filepath as personfilepath,filestore.studentid, uploads.filename as filename,byuser,type,users.name from uploads
inner join users on users.id=byuser
inner join filestore on filestore.studentid=users.id
	where uploads.id=:id';
	$s=$pdo->prepare($sql);
	$s->bindValue(':id',$id);
	$s->execute();
	

	}
		catch(PDOException $e){
		echo 'couldnt retrieve files'.$e->getMessage();
	}
		
$result=$s->fetchAll();
	return $result;
	
  }
  
  
  
  

function retrieveNewUpload($mid){
   
   
	
	include 'db.inc.php';
	try{
		
	$sql="select uploads.id as id,uploads.description, uploads.filepath as filepath,previewpath,filestore.filepath as personfilepath,filestore.studentid, uploads.filename as filename,byuser,type,users.name from uploads
inner join users on users.id=byuser
inner join filestore on filestore.studentid=users.id
	where new=1 and seennew !=$mid";
	$s=$pdo->prepare($sql);
	$s->bindValue(':id',$id);
	$s->execute();
	

	}
		catch(PDOException $e){
		echo 'couldnt retrieve new files'.$e->getMessage();
	}
		
$result=$s->fetchAll();
	foreach($result as $row){
	setUploadOld($row['id'],$_SESSION['id']);
}
	return $result;
	
}



  function setUploadOld($id,$mid){
  include 'db.inc.php';
  try{
 $pdo->exec("update uploads set new=0 where id=$id and seennew=$mid ");
 
  }catch(PDOException $e){
     $output='unable to  set new upload to old.please try again later.'.$e->getMessage();
   include 'alerts.php';
  }
  
}


  
  
  function isUploadNew($userid,$mid){
  include 'db.inc.php';
  try{
$s= $pdo->query("select new,seennew from uploads where id=$userid and seennew=$mid ");
 
  }catch(PDOException $e){
     $output='unable to check if upload is new.please try again later.'.$e->getMessage();
   include 'alerts.php';
  }
  if($s['new']==1){
  	return true;
  }else{
  	return false;
  }
  }
  
function  retrieveUploadExp($id){
   
   
	include 'db.inc.php';
	try{
		
	$sql='select uploads.id,uploads.description, uploads.filepath as filepath,previewpath,filestore.filepath as personfilepath,filestore.studentid, uploads.filename,byuser,type,users.name from uploads
inner join users on users.id=byuser
inner join filestore on filestore.studentid=users.id
	where uploads.id!=:id';
	$s=$pdo->prepare($sql);
	$s->bindValue(':id',$id);
	$s->execute();
	

	}
		catch(PDOException $e){
		echo 'couldnt retrieve files'.$e->getMessage();
	}
	
	$result=$s->fetchAll();
	return $result;
}

function addToLib($id,$userid){
   
   include 'db.inc.php';
   try{
   $pdo->query("insert into userlib set uploadid=$id,userid=$userid");
}catch(PDOException $e){
		$output= 'couldn\'t add file to your library please try again later'.$e->getMessage();
		include 'alerts.php';
	}

   
}
**/

?>