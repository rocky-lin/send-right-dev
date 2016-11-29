<?php

  include_once 'includes/db.class.php';

  $response=array();
  $db = new Db();

  $templateId = $_POST['templateId'];

   $result = $db -> getTemplatesById( $templateId);
   if ($result==-1) {
     $response['code']=-1;
     $response['message']='Database error';
     echo  json_encode($response);
     return;
   }

   $response['code']=0;
   $response['message']='success';
   $response['name']=$result[0]['TemplateName'];
   $response['content']=html_entity_decode ($result[0]['TemplateContent']);

   echo  json_encode($response);
?>
