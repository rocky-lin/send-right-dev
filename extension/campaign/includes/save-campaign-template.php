<?php 
require "../../../index.php"; 
print "<pre>";

use App\User; 
use App\CampaignTemplate; 
 

CampaignTemplate::create([
    'account_id' => User::getUserAccount(), 
    'name'=> $_POST['name'],
    'content'  => htmlentities($_POST['content']), 
    'type' =>$_POST['type'],
    'category' => $_POST['category']
]);



print "<pre>";
 print_r($_POST);
 



