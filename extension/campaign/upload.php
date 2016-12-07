<?php
  require_once('includes.php');
  include_once 'config.php';



    use App\Media;
    use App\User;




$todayh = getdate();
$filename= "upload-file-".$todayh['seconds'].$todayh['minutes'].$todayh['hours'].$todayh['mday']. $todayh['mon'].$todayh['year'];


//print "file name " . $filename;





//
//
//    print"<pre>";
//        print_r($_FILES);
//    print "</pre>";

  if ( 0 < $_FILES['file']['error'] ) {
      echo 'Error: ' . $_FILES['file']['error'] . '<br>';
  }
  else {


      $ext=explode('.',$_FILES['file']['name'])[1];
      $isUploaded = move_uploaded_file($_FILES['file']['tmp_name'], UPLOADS_DIRECTORY.$filename.'.'.$ext);

      if($isUploaded) {
          //insert into media
          Media::create([
              'account_id'=>User::getUserAccount(),
              'name'=>$filename.'.'.$ext,
              'path'=>UPLOADS_URL
          ]);
      }

  }

?>
