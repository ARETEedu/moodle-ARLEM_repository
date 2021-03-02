<?php

require_once('../../../../config.php');

//the variables which  are passed from Unity application
$token = filter_input(INPUT_POST, 'token');
$userid = filter_input(INPUT_POST, 'userid');
$sessionid = filter_input(INPUT_POST, 'sessionid');
$public = filter_input(INPUT_POST, 'public');

//if the file is received from Unity application
if (isset($_FILES['myfile'])){

    $filename = $_FILES['myfile']['name']; //file name
    $file = $_FILES['myfile']['tmp_name'];
     
    //convert the file to base64 string
    $file_base64 = base64_encode(file_get_contents($file)); 

    //To get file extension
    //$fileExt = pathinfo($img, PATHINFO_EXTENSION) ;
    
    
    //Get the thumbnail
    if(isset($_FILES['thumbnail'])){
        $thumbnail = $_FILES['thumbnail']['tmp_name'];
        //convert the thumbnail  to base64 string
        $thumb_base64 = base64_encode(file_get_contents($thumbnail)); 
    }

    //check public key if exist and is true
    if(isset($public) && $public == 1){
        $public_upload_privacy = 1;  
    }
    else
    {
        $public_upload_privacy = 0;
    }
    
     $data = array('base64' => $file_base64, 'token' => $token, 'filename' => $filename, 'userid' => $userid, 'sessionid' => $sessionid, 'thumbnail' => $thumb_base64, 'public' => $public_upload_privacy);
    
     $ch = curl_init($CFG->wwwroot . '/mod/arete/classes/webservice/upload.php');
     curl_setopt($ch, CURLOPT_POST, true);
     curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);


     $response = curl_exec($ch);
                 
     if($response == true){

         echo $response;
        
        //OR move the actual file to the destination
        //    move_uploaded_file($tmpimg, $destination . $img );    
        
     }else{
         echo 'Error: ' . curl_error($ch);
     }
     
    curl_close($ch);
     
}
else{
	echo "[error] there is no data with name [myfile]";
        exit();
}

