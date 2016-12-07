<?php
require_once ('includes.php');
include_once 'config.php';
use App\User;
use App\Media;

$files = [];

//get all files in uploads folder
//$files = array_diff(scandir(UPLOADS_DIRECTORY), array('.', '..'));

$files1 = Media::where('account_id', User::getUserAccount())->get();

foreach($files1 as $file) {
    $files[] = $file->name;
}


//
//print "<pre>";
//print_r($files);
//print "</pre>";
//
//exit;
//creating response
$response=array();

$response['code']=0;
$response['files']=$files;
$response['directory']=UPLOADS_URL;

//
//print "<pre>";
//print_r($response);
//print "</pre>";
//convert to json
echo json_encode($response);
?>
