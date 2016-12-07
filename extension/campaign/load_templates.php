<?php
include_once 'includes/db.class.php';
 require_once ('includes.php');


  use App\Campaign; 


$response = array();
$rows = Campaign::where('account_id', App\User::getUserAccount())->get()->toArray();
// print "<pre>"; 
// print_r($campaigns);
// print "</pre>";


// exit;


// $db = new Db();


// $rows = $db -> select();
// $response=array();



// if($rows==-1)
// {
//    $response['code']=-1;
//    echo json_encode($response);
//    return;
// }
// if($rows==0)
// {
//    //not found
//    $response['code']=1;
//    echo json_encode($response);
//    return;
// }
$response['code']=0;
$response['files']=$rows;
// $response['files'] = $rows[0]['id'];
// print " rows " . $rows[0]['id'];
// print "<pre>";
// print_r($rows);
// print "</prr>";
// exit;  
 
echo json_encode($response); 
